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
  options: Object,
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
                alert('１ページをリロードして再実行してください');
              }
              else {
                const index = allMembers.value.findIndex(obj => obj.id === curMember.id);
                if (index != -1) {
                  allMembers.value[index].isSelected = true;
                }
                else {
                  alert('２ページをリロードして再実行してください');
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

const closeModal = () => {
  editingMemberList.value = false;
};

// const members = ref([{id: 1, name: 'テストメンバー1'}, {id: 2, name: 'テストメンバー2'}, {id: 3, name: 'テストメンバー3'}]);
// const members = ref([{id: 1, name: 'テストメンバー1'}, {id: 2, name: 'テストメンバー2'}, {id: 3, name: 'テストメンバー3'}, {id: 4, name: 'テストメンバー4'}, {id: 5, name: 'テストメンバー5'}, {id: 6, name: 'テストメンバー6'}, {id: 7, name: 'テストメンバー7'}, {id: 8, name: 'テストメンバー8'}, {id: 9, name: 'テストメンバー9'}]);
</script>

<template>
  <article :id="'MemberListWrapper' + props.options.index" class="MemberListWrapper">
    <header class="MemberListHeader">
      <h3 class="MemberListHeading">本日のメンバー</h3>
    </header>

    <div class="MemberListContainer">
      <ul class="MemberList">
        <button type="button" @click="editMemberList" class="MemberListEditButton">メンバーリスト編集</button>        
        <MemberListItem v-if="listMembers.length !== 0" v-for="member in listMembers" :key="member.id" :heading="member.name" :options="{index: member.id}" />
      </ul>
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
      <button v-if="allMembers.length !== 0" type="button" @click="" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">決定</button>
      <button v-if="allMembers.length === 0" type="button" @click="closeModal" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">閉じる</button>
    </div>
  </div>
</Modal>
</template>

<style lang="scss">
</style>
