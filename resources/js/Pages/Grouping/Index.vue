<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout100vh.vue';
import { Head } from '@inertiajs/vue3';
import { Sortable, Plugins } from '@shopify/draggable';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import MemberList from '@/Components/MemberList.vue';
import GroupList from '@/Components/GroupList.vue';

const props = defineProps({
  members: Object,
  groups: Object,
});

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

  for (let i = 1; i < SortableContainers.length; i++) {
    GroupMemberListItemContainer.push(SortableContainers[i]);
  }


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
  <Head title="本日のグループ分け" />

  <AuthenticatedLayout>
    <template #header>
      <h2
          class="text-xl font-semibold leading-tight text-gray-800"
      >
        本日のグループ分け
      </h2>
    </template>

    <div class="py-4 PageContent">
      <div class="h-full mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="PageContentLayout">
          <section id="MemberContainer" class="MemberContainer">
            <MemberList :members="props.members" :options="{index: 1}" />
          </section>
          <section id="GroupContainer" class="GroupContainer">
            <GroupList :groups="props.groups" :options="{index: 1}" />
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="scss">
.draggable--is-dragging,
.draggable--is-dragging * {
  cursor: grabbing;
}

.PageContent {
  height: calc(100% - 64px - 73px);
  color: #ffffff;
}

.PageContentLayout {
  display: flex;
  flex-direction: column;
  gap: 2%;
  height: 100%;

  @media screen and (min-width: 1024px) {
    flex-direction: row;
  }
}

.MemberContainer,
.GroupContainer {
  overflow: hidden;
  background-color: #ffffff;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);

  @media screen and (min-width: 640px) {
    border-radius: 0.5rem;
  }
}

.MemberContainer {
  flex: 1 1 28%;

}

.GroupContainer {
  flex: 1 1 70%;
}
</style>