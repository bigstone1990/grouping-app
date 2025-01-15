<script setup>
import { onMounted } from 'vue';
import { isDraggableMemberHTML } from '@/grouping'

const props = defineProps({
  group: Object,
});

const sortable = defineModel("sortable");
const dropzones = defineModel("dropzones");

onMounted(() => {
  props.group.members.forEach(member => {
    const index = dropzones.value.findIndex(dropzone => dropzone.group_id === props.group.group_id);
    if (index != -1) {
      dropzones.value[index].issuedNumber += 1;

      const groupMemberListItemElement = document.createElement('div');
      groupMemberListItemElement.id = 'GroupMemberListItem' + dropzones.value[index].group_id + '-' + dropzones.value[index].issuedNumber;
      groupMemberListItemElement.classList.add('GroupMemberListItem');
      groupMemberListItemElement.dataset.dropzoneId = dropzones.value[index].group_id + '-' + dropzones.value[index].issuedNumber;
      
      const deleteButtonElement = document.createElement('button');
      deleteButtonElement.setAttribute('type', 'button');
      deleteButtonElement.classList.add('deleteGroupMemberListItemButton')
      deleteButtonElement.textContent = "×";
      deleteButtonElement.addEventListener('click', deleteGroupMemberListItem);

      const dropzoneElement = document.createElement('div');
      dropzoneElement.classList.add('Dropzone');
      dropzoneElement.dataset.groupId = props.group.group_id;

      const memberElement = document.createElement('div');
      memberElement.id = 'Member' + member.member_id;
      memberElement.classList.add('MemberListItem', 'Member--isDraggable');
      memberElement.dataset.memberId = member.member_id;
      memberElement.innerHTML = isDraggableMemberHTML(member.member_name);

      dropzoneElement.appendChild(memberElement);
      groupMemberListItemElement.appendChild(deleteButtonElement);
      groupMemberListItemElement.appendChild(dropzoneElement);

      const container = document.getElementById('GroupMemberList' + props.group.group_id);
      container.appendChild(groupMemberListItemElement);

      dropzones.value[index].data.push({ id: props.group.group_id + '-' + dropzones.value[index].issuedNumber});
    }
  });
});

const addDropzone = () => {
  const index = dropzones.value.findIndex(dropzone => dropzone.group_id === props.group.group_id);
    if (index != -1) {
      dropzones.value[index].issuedNumber += 1;

      const groupMemberListItemElement = document.createElement('div');
      groupMemberListItemElement.id = 'GroupMemberListItem' + dropzones.value[index].group_id + '-' + dropzones.value[index].issuedNumber;
      groupMemberListItemElement.classList.add('GroupMemberListItem');
      groupMemberListItemElement.dataset.dropzoneId = dropzones.value[index].group_id + '-' + dropzones.value[index].issuedNumber;
      
      const deleteButtonElement = document.createElement('button');
      deleteButtonElement.setAttribute('type', 'button');
      deleteButtonElement.classList.add('deleteGroupMemberListItemButton')
      deleteButtonElement.textContent = "×";
      deleteButtonElement.addEventListener('click', deleteGroupMemberListItem);

      const dropzoneElement = document.createElement('div');
      dropzoneElement.classList.add('Dropzone');
      dropzoneElement.dataset.groupId = props.group.group_id;

      groupMemberListItemElement.appendChild(deleteButtonElement);
      groupMemberListItemElement.appendChild(dropzoneElement);
      
      const container = document.getElementById('GroupMemberList' + props.group.group_id);
      container.appendChild(groupMemberListItemElement);

      dropzones.value[index].data.push({ id: props.group.group_id + '-' + dropzones.value[index].issuedNumber});

      sortable.value.addContainer(dropzoneElement);
    }
};

const deleteGroupMemberListItem = (e) => {
  const groupIndex = dropzones.value.findIndex(group => group.group_id === props.group.group_id);
  if (groupIndex != -1) {
    const dropzoneIndex = dropzones.value[groupIndex].data.findIndex(dropzone => dropzone.id == e.target.parentElement.dataset.dropzoneId)
    if (dropzoneIndex != -1) {
      dropzones.value[groupIndex].data.splice(dropzoneIndex, 1)
      sortable.value.removeContainer(e.target.parentElement);
      e.target.parentElement.remove();
    }
  }
};
</script>

<template>
  <div class="GroupListItem">
    <div class="GroupListItemContent">
      <header class="GroupListItemHeader">
          <h4 class="GroupListItemHeading">{{ props.group.group_name }}</h4>
      </header>
      <div class="GroupMemberListContainer">
        <div :id="'GroupMemberList' + props.group.group_id" class="GroupMemberList">
          <button type="button" @click="addDropzone" class="DropzoneAddButton">枠を追加</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
</style>
