<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MemberList from '@/Components/MemberList.vue';
import GroupList from '@/Components/GroupList.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Sortable, Plugins } from '@shopify/draggable';
import { ref, onMounted, onBeforeUnmount } from 'vue';


const props = defineProps({
  'groupings': Object,
});

const updateGrouping = () => {
  // form.put(route('groups.update', {group: id}));
};

const sortContainers = ref(null);
const sortable = ref(null);

onMounted(() => {
  sortContainers.value = document.querySelectorAll('.MemberList, .GroupMemberListItem');
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

  let GroupMemberListItemContainer = [];
  const SortableContainers = sortable.value.containers;

  for (let i = 0; i < SortableContainers.length; i++) {
    let SortableContainer = SortableContainers[i];
    if (!SortableContainer.classList.contains('MemberList')) {
      GroupMemberListItemContainer.push(SortableContainer);
    }
  }

  console.log(GroupMemberListItemContainer);


  const GroupMemberListItemCapacity = 1;
  let GroupMemberListItemChildren;
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
      if (GroupMemberListItemContainer.includes(OverContainer)) {
        GroupMemberListItemChildren = sortable.value.getDraggableElementsForContainer(OverContainer).length;
        if (GroupMemberListItemChildren >= GroupMemberListItemCapacity) {
          evt.overContainer.classList.add('draggable-container-parent--capacity');
          CapacityReached = true;
        }
      }
    }
  });

  sortable.value.on('drag:out:container', (evt) => {
    OverContainer = evt.overContainer;
    if (SourceContainer !== OverContainer) {
      if (GroupMemberListItemContainer.includes(OverContainer)) {
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
    if (GroupMemberListItemContainer.includes(OverContainer)) {
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
            <div class="GroupingEditPageContentLayout">
              <section id="MemberContainer" class="MemberContainer">
                <MemberList :options="{index: 1}" />
              </section>
              <section id="GroupContainer" class="GroupContainer">
                <GroupList :groups="props.groupings" :options="{index: 1}" :isDraggablePage="true" />
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
