<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GroupListForRead from '@/Components/GroupListForRead.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import { Japanese } from "flatpickr/dist/l10n/ja.js";
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { customDateToString } from '@/common';
import axios from 'axios';

const user = usePage().props.auth.user;

const groupings = ref();

const date = ref(new Date());
date.value.setDate(date.value.getDate() - 1);
date.value = customDateToString(date.value);

const fpDate = ref();

onMounted(() => {
  fpDate.value = flatpickr("#date", {
    "locale": Japanese,
    maxDate: new Date().fp_incr(-1),
    minDate: new Date().fp_incr(-30),
    onReady: function (selectedDates, dateStr, instance) {
      if (instance.calendarContainer) {
        const yearElement = instance.calendarContainer.querySelector(".cur-year");
        if (yearElement) {
          const yearLabel = document.createElement("span");
          yearLabel.textContent = "年";
          yearElement.parentNode.before(yearLabel);
        }
      }
    },
  });
  getGroupingData();
});

onBeforeUnmount(() => {
  if (fpDate.value) {
    fpDate.value.destroy();
    fpDate.value = null;
  }
})

const getGroupingData = async () => {
  try {
    await axios.get('/api/getPastGroupings/', {
      params: {
        userId: user.id,
        date: date.value,
      }
    }).then(
      res => {
        if (res.data.checkId === false) {
          alert('データを閲覧できません');
        }
        else if (res.data.checkDate === false) {
          alert('不正な日付が入力されています')
        }
        else {
          groupings.value = res.data.groupings;
        }
      }
    )
  } catch (error) {
    
  }
}

const prevDate = () => {
  if (date.value < customDateToString(fpDate.value.config._minDate) || date.value > customDateToString(fpDate.value.config._maxDate)) {
    alert('不正な日付が入力されています');
    return;
  }
  else if (date.value == customDateToString(fpDate.value.config._minDate)) {
    alert('この日付より前の日付は閲覧できません');
  }
  else {
    const dateTmp = new Date(date.value + 'T00:00:00Z');
    dateTmp.setDate(dateTmp.getDate() - 1);
    date.value = dateTmp.toISOString().slice(0, 10);

    getGroupingData();
  }
}

const nextDate = () => {
  if (date.value < customDateToString(fpDate.value.config._minDate) || date.value > customDateToString(fpDate.value.config._maxDate)) {
    alert('日付フォームに不正な値が入力されています');
    return;
  }
  else if (date.value == customDateToString(fpDate.value.config._maxDate)) {
    alert('この日付より後の日付は閲覧できません');
  }
  else {
    const dateTmp = new Date(date.value + 'T00:00:00Z');
    dateTmp.setDate(dateTmp.getDate() + 1);
    date.value = dateTmp.toISOString().slice(0, 10);

    getGroupingData();
  }
}
</script>

<template>
  <Head title="過去のグループ分け" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="text-xl font-semibold leading-tight text-gray-800"
      >
        過去のグループ分け
      </h2>
    </template>

    <div class="PageContainer">
      <div class="PageWrapper">
        <div class="Page">
          <div class="PageContent">
            <div class="flex flex-col-reverse sm:flex-row gap-4 justify-between mb-4 w-full">
              <div class="flex flex-col mx-auto sm:mx-0">
                <div class="flex gap-2 items-center">
                  <button type="button" @click="prevDate" class="MoveDateButton">&lt;前日</button>
                  <div>
                    <TextInput
                      id="date"
                      type="text"
                      class="block mx-auto w-48"
                      v-model="date"
                      @input="getGroupingData"
                    />
                  </div>
                  <button type="button" @click="nextDate" class="MoveDateButton">翌日&gt;</button>
                </div>
                <p class="text-sm">※過去30日間まで閲覧できます</p>
              </div>
              <Link as="button" :href="route('groupings.index')" class="ml-auto sm:ml-0 h-full text-white bg-gray-500 border-0 py-2 px-8 hover:bg-gray-600 rounded">戻る</Link>
            </div>
            <div class="GroupingIndexPageContentLayout">
              <section id="GroupContainer" class="GroupContainer">
                <GroupListForRead v-if="groupings" :groups="groupings" :date="date" />
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

.flatpickr-current-month {
  display: flex !important;
  flex-direction: row-reverse !important;
  align-items: center !important;
  justify-content: center !important;
}

.MoveDateButton {
  padding: 0.5rem 0.7rem;
  border-radius: 0.5rem;
  border: 1px solid #d1d5db;
  box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.05);
  background-color: #ffffff;
  font-size: 1rem;
  line-height: 1.5rem;

  @media screen and (min-width: map.get($breakpoint-data, smartphone-wide)) {
    padding: 0.5rem 1rem;
  }

  &:hover {
    background-color: #f3f4f6;
  }

  &.IsDisabled {
    background-color: #d1d5db;
  }
}
</style>
