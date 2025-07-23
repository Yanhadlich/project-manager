<script setup lang="ts">
import { ref, computed, defineProps, defineEmits } from 'vue';

interface Option {
  value: number | string;
  label: string;
}

const props = defineProps<{
  options: Option[];
  modelValue: (number | string)[];
  placeholder?: string;
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: (number | string)[]): void;
}>();

const isOpen = ref(false);
const search = ref('');

const toggleOpen = () => {
  isOpen.value = !isOpen.value;
};

const filteredOptions = computed(() =>
  props.options.filter((opt) =>
    opt.label.toLowerCase().includes(search.value.toLowerCase())
  )
);

const selectedLabels = computed(() =>
  props.options
    .filter((opt) => props.modelValue.includes(opt.value))
    .map((opt) => opt.label)
);

function toggleOption(id: number | string) {
  const selected = [...props.modelValue];
  const index = selected.indexOf(id);
  if (index > -1) {
    selected.splice(index, 1);
  } else {
    selected.push(id);
  }
  emit('update:modelValue', selected);
}

</script>

<template>
  <div class="space-y-1">
    <div class="relative">
      <button
        type="button"
        class="w-full border rounded px-4 py-2 text-left bg-white text-gray-800 shadow-sm dark:bg-gray-800 dark:text-white dark:border-gray-700"
        @click="toggleOpen"
      >
        {{ selectedLabels.length ? selectedLabels.join(', ') : (placeholder || 'Selecione...') }}
      </button>

      <div
        v-show="isOpen"
        class="absolute z-10 mt-1 w-full bg-white border rounded shadow max-h-80 overflow-y-auto dark:bg-gray-900 dark:border-gray-700"
      >
        <div class="p-2 border-b dark:border-gray-700">
          <input
            type="text"
            v-model="search"
            placeholder="Buscar..."
            class="w-full px-3 py-2 text-sm border rounded bg-gray-50 text-gray-900 dark:bg-gray-800 dark:text-white dark:border-gray-700"
          />
        </div>

        <div>
          <label
            v-for="opt in filteredOptions"
            :key="opt.value"
            class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer text-gray-800 dark:text-white"
          >
            <input
              type="checkbox"
              :value="opt.value"
              :checked="modelValue.includes(opt.value)"
              @change="toggleOption(opt.value)"
              class="form-checkbox mr-2 text-indigo-600 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-indigo-500"
            />
            {{ opt.label }}
          </label>

          <p v-if="!filteredOptions.length" class="p-4 text-sm text-gray-500 dark:text-gray-400">Nenhum item encontrado.</p>
        </div>
      </div>
    </div>
  </div>
</template>
