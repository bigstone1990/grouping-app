<script setup>
import GroupMemberListItem from './GroupMemberListItem.vue';

const props = defineProps({
  heading: String,
  options: Object,
});
</script>

<template>
  <li class="GroupListItem">
    <div class="GroupListItemContent">
      <header class="GroupListItemHeader">
          <h4 class="GroupListItemHeading">{{ props.heading }}</h4>
      </header>
      <div class="GroupMemberListContainer">
        <ul v-if="props.options.blocks > 0" class="GroupMemberList">
          <GroupMemberListItem v-for="block in props.options.blocks" :key="props.options.index + '-' + block" :options="{index: props.options.index + '-' + block}" />
        </ul>
        <div v-else class="flex justify-center items-center px-4 h-full">
          <p>枠がありません</p>
        </div>
      </div>
    </div>
  </li>
</template>

<style lang="scss">
.GroupListItem {
  flex: 1 0 auto;
  overflow: hidden;
  width: 100%;
  background-color: #ffffff;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);
  border-radius: 0.5rem;

  @media screen and (min-width: 1024px) {
    width: calc(calc(100% - 1rem) / 2);
    flex: initial;
  }
}

.GroupListItemContent {
  display: flex;
  flex-direction: column;
}

.GroupListItemHeader {
  flex: 0 0 3rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0.5rem;
  background-color: #ffa500;
}

.GroupListItemHeading {
  color: currentColor;
  font-size: 1.2rem;
  font-weight: 700;
}

.GroupMemberListContainer {
  padding-top: 1rem;
  padding-bottom: 1rem;
  background-image: repeating-linear-gradient(-45deg, currentColor 0%, currentColor 40%, #111827 40%, #111827 50%, currentColor 50%);
  background-size: 0.8rem 0.8rem;
}

.GroupMemberList {
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;
  min-height: 3rem;


  @media screen and (min-width: 1024px) {
    flex-direction: column;
    flex-wrap: nowrap;
  }
}
</style>