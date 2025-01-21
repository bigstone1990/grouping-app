<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MemberListForEdit from '@/Components/MemberListForEdit.vue';
import GroupListForEdit from '@/Components/GroupListForEdit.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Sortable, Plugins } from '@shopify/draggable';
import { ref, onMounted, onBeforeUnmount, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  'groupings': Object,
});

const user = usePage().props.auth.user;

const curMembers = ref([]);
if (props.groupings.length !== 0) {
  props.groupings.forEach(grouping => {
    if (grouping.members !== 0) {
      grouping.members.forEach(member => {
        const data = {
          member_id: member.member_id,
        };
        curMembers.value.push(data);
      });
    }
  });
}

const listMembers = ref([]);

const dropzones = ref([]);
if (props.groupings.length !== 0) {
  props.groupings.forEach(grouping => {
    const data = {
      group_id: grouping.group_id,
      issuedNumber: 0,
      data: [],
    };
    dropzones.value.push(data);
  });
}

const dropzoneContainer = ref([]);

const memberCounts = computed(() => {
  return curMembers.value.length;
})

const dropzoneCounts = computed(() => {
  let count = 0;
  if (dropzones.value.length !== 0) {
    dropzones.value.forEach(dropzone => {
      if (dropzone.data.length !== 0) {
        count = count + dropzone.data.length
      }
    });
  }
  return count;
})

const updateGrouping = () => {
  let data = [];
  
  const dropzoneElements = document.querySelectorAll('.Dropzone');
  if (dropzoneElements.length !== 0) {
    dropzoneElements.forEach(dropzoneElement => {
      const groupId = dropzoneElement.dataset.groupId;
      const memberElement = dropzoneElement.querySelector('.MemberListItem');
      if (memberElement) {        
        const memberId = memberElement.dataset.memberId;

        data.push({group_id: groupId, member_id: memberId});
      }
    });
  }
  
  router.put(route('groupings.update', {user_id: user.id, date: 'today'}), data);
};

const autoGrouping = async () => {
  if (confirm('自動編成を実施しますか？')) {
    if (memberCounts.value !== dropzoneCounts.value) {
      alert('メンバー数と枠数を合わせて再実行してください');
    }
    else {
      const group = [];
      dropzones.value.forEach(dropzone => {
        group.push({group_id: dropzone.group_id, group_number: dropzone.data.length});

      });
      const sendData ={members: curMembers.value, groups: group}
      
      try {
        await axios.get('/api/getAutoGroupings/', {
          params: {
            userId: user.id,
            sendData: sendData,
          }
        }).then(
          res => {
            if (res.data.checkId === false) {
              alert('データを閲覧できません');
            }
            else if (res.data.checkSendData === false) {
              alert('不正な操作がありました');
            }
            else {
              allocateMemberToMemberList();

              allocateMemberToGroup(res.data.groupings);

              if (res.data.checkGroupingMembers === false || res.data.checkGroupingGroups === false) {
                alert('グループに振り分けできなかったメンバーがいます');
              }
            }
          }
        )
      } catch (error) {
        
      }
    }
  }
}

const allocateMemberToMemberList = () => {
  const memberListElement = document.getElementById('MemberList');
  curMembers.value.forEach(curMember => {
    const memberId = curMember.member_id;
    const memberElement = document.getElementById('Member' + memberId);
    memberListElement.appendChild(memberElement);
  });
}

const allocateMemberToGroup = (grouping) => {
  grouping.forEach(groupingItem => {
    const groupId = groupingItem.group_id;
    if (groupId !== null) {
      const members = groupingItem.members;
      if (members.length !== 0) {
        const dropzoneElements = document.querySelectorAll(`[data-group-id="${groupId}"]`);
        if (dropzoneElements.length !== 0 && members.length <= dropzoneElements.length) {
          for (let i = 0; i < members.length; i++) {
            const memberElement = document.getElementById('Member' + members[i].member_id);
            dropzoneElements[i].appendChild(memberElement);
          }
        }
      }
    }
  });
}

const sortContainers = ref(null);
const sortable = ref(null);

onMounted(() => {
  sortContainers.value = document.querySelectorAll('.MemberList, .Dropzone');
  if (sortContainers.value.length === 0) {
    return false;
  }

  sortable.value = new Sortable(sortContainers.value, {
    draggable: '.Member--isDraggable',
    mirror: {
      constrainDimensions: true,
    },
    delay: {
      mouse: 0,
      drag: 0,
      touch: 200
    },
    plugins: [Plugins.ResizeMirror],
  });

  const dropzoneElement = document.querySelectorAll(".Dropzone");
  if (dropzoneElement.length !== 0) {
    dropzoneElement.forEach(element => {
      dropzoneContainer.value.push(element);
    });
  }

  const DropzoneCapacity = 1;
  let DraggableElementsForContainer;
  let DropzoneChildren;
  let CapacityReached;
  let SourceContainer;
  let OverContainer;

  sortable.value.on('drag:start', (evt) => {
    SourceContainer = evt.sourceContainer;
  });

  sortable.value.on('drag:over:container', (evt) => {
    SourceContainer = evt.sourceContainer;
    OverContainer = evt.overContainer;
    if (SourceContainer !== OverContainer) {
      if (dropzoneContainer.value.includes(OverContainer)) {
        DraggableElementsForContainer = sortable.value.getDraggableElementsForContainer(OverContainer)
        DropzoneChildren = DraggableElementsForContainer.length;
        
        DraggableElementsForContainer.forEach(element => {
          if (element.classList.contains('draggable-source--is-dragging')) {
            DropzoneChildren = DropzoneChildren - 1;
          }
        });
        if (DropzoneChildren >= DropzoneCapacity) {
          evt.overContainer.classList.add('draggable-container-parent--capacity');
          CapacityReached = true;
        }
      }
    }
  });

  sortable.value.on('drag:out:container', (evt) => {
    OverContainer = evt.overContainer;
    if (SourceContainer !== OverContainer) {
      if (dropzoneContainer.value.includes(OverContainer)) {
        if (OverContainer.classList.contains('draggable-container-parent--capacity')) {
          OverContainer.classList.remove('draggable-container-parent--capacity');
          CapacityReached = false;
        }
      }
    }
  });

  sortable.value.on('sortable:sort', (evt) => {
    if (!CapacityReached) {
      return;
    }
    else {
      evt.cancel();
    }
  });

  sortable.value.on('sortable:sorted', (evt) => {
    return;
  });

  sortable.value.on('drag:stop', (evt) => {
    if (dropzoneContainer.value.includes(OverContainer)) {
      if (OverContainer.classList.contains('draggable-container-parent--capacity')) {
        OverContainer.classList.remove('draggable-container-parent--capacity');
        CapacityReached = false;
      }
    }
  })
});

onBeforeUnmount(() => {
  if (sortable.value !== null) {
    sortable.value.destroy();
    sortable.value = null;
  }
})
</script>

<template>
  <Head title="本日のグループ分け 編集" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        本日のグループ分け 編集
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <div class="flex gap-4 justify-end mb-4 w-full">
              <Link as="button" :href="route('groupings.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
              <button type="button" v-on:click="updateGrouping()" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">更新</button>
            </div>
            <div class="flex gap-4 justify-start mb-4 w-full">
              <button type="button" v-on:click="autoGrouping()" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">自動編成</button>
              <div class="bg-white border py-2 px-2 rounded">メンバー数: {{ memberCounts }}</div>
              <div class="bg-white border py-2 px-2 rounded">枠数: {{ dropzoneCounts }}</div>
            </div>
            <div class="GroupingEditPageContentLayout">
              <section id="MemberContainer" class="MemberContainer">
                <MemberListForEdit v-model:curMembers="curMembers" v-model:listMembers="listMembers" />
              </section>
              <section id="GroupContainer" class="GroupContainer">
                <GroupListForEdit v-model:sortable="sortable" v-model:dropzones="dropzones" v-model:dropzoneContainer="dropzoneContainer" :groups="props.groupings" />
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="scss">
@use '../../../sass/grouping.scss';
</style>
