<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Sortable, Plugins } from '@shopify/draggable';
import { ref, reactive, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
  groups: Object,
});

const groupOrderData = reactive({
  orderData: [],
});

const updateOrder = () => {
  router.patch(route('groups.ordering.update'), groupOrderData);
};

props.groups.forEach(group => {
  groupOrderData.orderData.push({id: group.id, order: group.order});
});

const sortContainers = ref(null);
const sortable = ref(null);

onMounted(() => {
  sortContainers.value = document.querySelectorAll('.GroupOrderList');
  if (sortContainers.value.length === 0) {
    return false;
  }

  sortable.value = new Sortable(sortContainers.value, {
    draggable: '.Group--isDraggable',
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

  let GroupList;

  sortable.value.on('drag:stopped', (evt) => {
    groupOrderData.orderData = [];
    GroupList = sortable.value.containers[0].children;
    for (let i = 0; i < GroupList.length; i++) {
      let id = GroupList[i].dataset.id;
      let order = i + 1;

      groupOrderData.orderData.push({id: id, order: order});
    }
  });
});

onBeforeUnmount(() => {
  if (sortable.value !== null) {
    sortable.value.destroy();
  }
});
</script>

<template>
  <Head title="グループ順編集" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        グループ順編集
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <section id="GroupOrderContainer" class="GroupOrderContainer">
              <article id="GroupOrderListWrapper" class="GroupOrderListWrapper">
                <header class="GroupOrderListHeader">
                  <h3 class="GroupOrderListHeading">グループ名</h3>
                </header>
  
                <div class="GroupOrderListContainer">
                  <ul v-if="props.groups.length !== 0" class="GroupOrderList">
                    <li v-for="group in props.groups" :key="group.id" :data-id="group.id" class="GroupOrderListItem Group--isDraggable">
                      <div class="GroupOrderListItemContent">
                        <h4 class="GroupOrderListItemHeading">{{ group.name }}</h4>
                        <div class="DragHandle"></div>
  
                        <div class="Pattern Pattern--typeHalftone"></div>
                        <div class="Pattern Pattern--typePlaced"></div>
                      </div>
                    </li>
                  </ul>
                  <div v-else class="flex justify-center items-center px-4 text-gray-600">
                    <p>グループがありません</p>
                  </div>
                </div>
              </article>
              <div class="mt-4 flex gap-4 justify-center">
                <Link as="button" :href="route('groups.index')" class="text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
                <button type="button" @click="updateOrder" class="text-white bg-indigo-500 border-0 py-2 px-8 hover:bg-indigo-600 rounded">更新</button>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="scss">
@use 'sass:map';
@use '../../../sass/variables.scss' as *;

.draggable--is-dragging,
.draggable--is-dragging * {
  cursor: grabbing;
}

.PageContainer {
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.PageWrapper {
  height: 100%;
  margin-left: auto;
  margin-right: auto;
  max-width: 80rem /* 1280px */;

  @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }

  @media screen and (min-width: map.get($breakpoint-data, tablet-wide)) {
    padding-left: 2rem;
    padding-right: 2rem;
  }
}

.Page {
  background-color: #ffffff;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);

  @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
    border-radius: 0.5rem;
  }
}

.PageContent {
  padding: 1rem;
  color: #ffffff;
}

.GroupOrderContainer {
  display: flex;
  flex-direction: column;
  max-width: 80%;
  margin-left: auto;
  margin-right: auto;
}

.GroupOrderListWrapper {
  display: flex;
  flex-direction: column;
  width: 100%;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.1);
}

.GroupOrderListHeader {
  flex: 0 0 3rem;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
  background-color: #111827;
}

.GroupOrderListHeading {
  color: currentColor;
  font-size: 1rem;
  font-weight: 700;
}

.GroupOrderListContainer {
  flex: 1 1 auto;
  overflow: hidden;
  padding-top: 1rem;
  padding-bottom: 1rem;
}

.GroupOrderList {
  overflow: scroll;
  display: flex;
  flex-direction: column;
  flex-wrap: nowrap;
  gap: 1rem;
  padding-left: 1rem;
  padding-right: 1rem;
  max-height: 322px;

  @media screen and (min-height: map.get($breakpoint-data, tablet-base)) {
    max-height: 423px;
  }

  @media screen and (min-height: map.get($breakpoint-data, tablet-wide)) {
    max-height: 679px;
  }
}

.GroupOrderListItemContent {
  position: relative;
  display: flex;
  align-items: center;
  padding: 1rem;
  background-color: #5cb85c;
  border-radius: 0.5rem;
}

.GroupOrderListItemHeading {
  flex: 1 1 auto;
  color: currentColor;
  font-size: 1rem;
  font-weight: 700;
  pointer-events: none;
  user-select: none;
}

.DragHandle {
  flex: 0 0 1rem;
  margin-left: 1rem;
  position: relative;
  width: 1rem;
  height: 1rem;
  background-color: currentColor;

  &::before,
  &::after {
    content: '';
    position: absolute;
    right: 0;
    left: 0;
    display: block;
    height: 0.2rem;
    background-color: #5cb85c;
  }

  &::before {
    top: 0.2rem;
  }

  &::after {
      bottom: 0.2rem;
  }
}

.Group--isDraggable {
  cursor: grab;

  &:focus {
    outline: none;
  }

  &:focus,
  &:hover {
    .GroupOrderListItemContent {
      background-color: #0042ff;

      .DragHandle {
        &::before,
        &::after {
          background-color: #0042ff;
        }
      }
    }
  }

  &.draggable-source--is-dragging {
    .GroupOrderListItemContent {
      background-color: #0042ff;

      .DragHandle {
        &::before,
        &::after {
          background-color: #0042ff;
        }
      }

      .Pattern--typeHalftone {
        opacity: 1;
        visibility: visible;
        animation-play-state: running;
      }
    }
  }

  &.draggable-source--placed {
    .GroupOrderListItemContent {
      .Pattern--typePlaced {
        opacity: 1;
        visibility: visible;
        animation-play-state: running;
      }
    }
  }

  &.draggable-mirror {
    z-index: 9999;

    .GroupOrderListItemContent {
      background-color: #0042ff;
      transform: scale(1.025);

      .DragHandle {
        &::before,
        &::after {
          background-color: #0042ff;
        }
      }
    }
  }
}
</style>
