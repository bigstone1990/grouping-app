<script setup>
import { onMounted } from 'vue';
import { isDraggableMemberHTML } from '@/grouping'

const props = defineProps({
  group: Object,
});

const dropzones = defineModel("dropzones");

onMounted(() => {
  props.group.members.forEach(member => {
    const index = dropzones.value.findIndex(group => group.group_id === props.group.group_id);
    if (index != -1) {
      dropzones.value[index].issuedNumber += 1;

      const dropzoneElement = document.createElement('div');
      dropzoneElement.id = 'Dropzone' + dropzones.value[index].group_id + '-' + dropzones.value[index].issuedNumber;
      dropzoneElement.classList.add('GroupMemberListItem');
      dropzoneElement.dataset.groupId = props.group.group_id;
      
      const memberElement = document.createElement('div');
      memberElement.id = 'Member' + member.member_id;
      memberElement.classList.add('MemberListItem', 'Member--isDraggable');
      memberElement.dataset.memberId = member.member_id;
      memberElement.innerHTML = isDraggableMemberHTML(member.member_name);

      dropzoneElement.appendChild(memberElement);

      const container = document.getElementById('GroupMemberList' + props.group.group_id);
      container.appendChild(dropzoneElement);
    }
  });

})

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
