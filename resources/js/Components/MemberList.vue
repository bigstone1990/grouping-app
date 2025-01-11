<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import MemberListItem from './MemberListItem.vue';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  members: Object,
});

const user = usePage().props.auth.user;
const curMembers = ref([]);
const listMembers = ref([]);
const allMembers = ref([]);

if (props.members.length !== 0) {
  props.members.forEach(member => {
    curMembers.value.push(member);
  });
}

const editingMemberList = ref(false);

const editMemberList = async () => {
  try {
    await axios.get('/api/getAllMembers/', {
      params: {
        userId: user.id,
      }
    }).then(
      res => {
        if (res.data.checkId === false) {
          alert('データを閲覧できません');
        }
        else {
          allMembers.value = [];
          if (res.data.members.length !== 0) {
            res.data.members.forEach(member => {
              const memberData = {
                id: member.id,
                name: member.name,
                isSelected: false,
              };
              allMembers.value.push(memberData);
            });
          }

          if (curMembers.value.length !== 0) {
            curMembers.value.forEach(curMember => {
              if (allMembers.value.length === 0) {
                alert('ページをリロードして再実行してください');
              }
              else {
                const index = allMembers.value.findIndex(obj => obj.id == curMember.id);
                if (index != -1) {
                  allMembers.value[index].isSelected = true;
                }
                else {
                  alert('ページをリロードして再実行してください');
                }
              }
            })
          };

          editingMemberList.value = true;
        }
      }
    )
  } catch (error) {
    
  }
};

const selectMembers = () => {
  if (allMembers.value.length === 0) {
    listMembers.value = [];
    curMembers.value = [];
  }
  else {
    allMembers.value.forEach(member => {
      const memberId = member.id;
      const memberName = member.name;

      if (!member.isSelected) {
        const curMemberIndex = curMembers.value.findIndex(obj => obj.id == memberId);

        if (curMemberIndex != -1) {
          curMembers.value.splice(curMemberIndex, 1);

          const listMemberindex = listMembers.value.findIndex(obj => obj.id == memberId);
          
          if (listMemberindex != -1) {
            listMembers.value.splice(listMemberindex, 1);
          }
          
          const deleteElement = document.querySelectorAll(`[data-member-id="${memberId}"]`);

        }
      }
      else {
        const curMemberIndex = curMembers.value.findIndex(obj => obj.id == memberId);

        if (curMemberIndex == -1) {
          if (!listMembers.value.find(obj => obj.id == memberId)) {
            const memberData = {id: memberId, name: memberName};
            curMembers.value.push(memberData)
            listMembers.value.push(memberData);
          }
        }
      }
    });
  }

  editingMemberList.value = false;
}

const closeModal = () => {
  editingMemberList.value = false;
};

</script>

<template>
  <article class="MemberListWrapper">
    <header class="MemberListHeader">
      <h3 class="MemberListHeading">本日のメンバー</h3>
    </header>

    <div class="MemberListContainer">
      <div class="MemberList">
        <button type="button" @click="editMemberList" class="MemberListEditButton">メンバーリスト編集</button>
        <MemberListItem v-if="listMembers.length !== 0" v-for="member in listMembers" :key="member.id" :heading="member.name" :memberId="member.id" />
      </div>
    </div>
  </article>
  <Modal :show="editingMemberList" @close="closeModal">
    <div class="p-6">
      <h2
        class="text-lg font-medium text-gray-900"
      >
        本日のメンバー編集
      </h2>

      <div class="EditMemberList">
        <div v-if="allMembers.length !== 0" class="EditMemberListLayout">
          <div v-for="member in allMembers" :key="member.id" class="EditMemberListItem" :class="{ 'IsChecked': member.isSelected }">
            <div class="flex items-center">
              <Checkbox :id="member.id" v-model:checked="member.isSelected" />
              <InputLabel :for="member.id" :value="member.name" class="flex-auto pl-2 py-4 leading-7 text-sm text-gray-600" :class="{ 'text-white': member.isSelected }" />
            </div>
          </div>
        </div>
        <div v-else class="text-sm">メンバーがいません</div>
      </div>

    <div class="mt-6 flex justify-end gap-4">
      <button v-if="allMembers.length !== 0" type="button" @click="closeModal" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">キャンセル</button>
      <button v-if="allMembers.length !== 0" type="button" @click="selectMembers" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">決定</button>
      <button v-if="allMembers.length === 0" type="button" @click="closeModal" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">閉じる</button>
    </div>
  </div>
</Modal>
</template>

<style lang="scss">
</style>
