<script setup>
import MemberListItem from './MemberListItem.vue';

const props = defineProps({
  members: Object,
  options: Object,
});
</script>

<template>
  <article :id="'MemberListWrapper' + props.options.index" class="MemberListWrapper">
    <header class="MemberListHeader">
      <h3 class="MemberListHeading">本日の掃除当番メンバー</h3>
    </header>

    <div class="MemberListContainer">
      <ul v-if="props.members.length !== 0" class="MemberList">
        <MemberListItem v-for="member in props.members" :key="member.id" :heading="member.name" :options="{index: member.id}" />
      </ul>
      <div v-else class="flex justify-center items-center px-4 h-full">
        <p>メンバーがいません</p>
      </div>
    </div>
</article>
</template>

<style lang="scss">
.MemberListWrapper {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.MemberListHeader {
  flex: 0 0 4rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
  background-color: #111827;
}

.MemberListHeading {
  color: currentColor;
  font-size: 1.2rem;
  font-weight: 700;
}

.MemberListContainer {
  flex: 1 1 auto;
  overflow: hidden;
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.MemberList {
  height: 100%;
  overflow: scroll;
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;

  @media screen and (min-width: 1024px) {
    flex-direction: column;
    flex-wrap: nowrap;
  }
}
</style>