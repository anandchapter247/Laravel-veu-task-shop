<template>
  <div class="top-16">
    <Listbox v-model="selectedCategory">
      <div class="mt-1">
        <ListboxButton
          class="
            relative
            w-full
            py-2
            pl-3
            pr-10
            text-left
            bg-white
            rounded-lg
            shadow-md
            cursor-default
            focus:outline-none
            focus-visible:ring-2
            focus-visible:ring-opacity-75
            focus-visible:ring-white
            focus-visible:ring-offset-orange-300
            focus-visible:ring-offset-2
            focus-visible:border-indigo-500
            sm:text-sm
          "
        >
          <!-- {selectedCategory.name ? selectedPerson.name : "Select person"} -->
          <span class="block truncate">{{
            selectedCategory.name ? selectedCategory.name : "All Categories"
          }}</span>
          <span
            class="
              absolute
              inset-y-0
              right-0
              flex
              items-center
              pr-2
              pointer-events-none
            "
          >
            <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
          </span>
        </ListboxButton>

        <transition
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <ListboxOptions
            class="
              w-full
              py-1
              mt-1
              overflow-auto
              text-base
              bg-white
              rounded-md
              shadow-lg
              max-h-60
              ring-1 ring-black ring-opacity-5
              focus:outline-none
              sm:text-sm
            "
          >
            <ListboxOption
              v-slot="{ active, selected }"
              v-for="person in category"
              :key="person.name"
              :value="person"
              as="template"
            >
              <li
                :class="[
                  active ? 'text-amber-900 bg-amber-100' : 'text-gray-900',
                  'cursor-default select-none relative py-2 pl-10 pr-4',
                ]"
              >
                <span
                  :class="[
                    selected ? 'font-medium' : 'font-normal',
                    'block truncate',
                  ]"
                  >{{ person.name }}</span
                >
                <span
                  v-if="selected"
                  class="
                    absolute
                    inset-y-0
                    left-0
                    flex
                    items-center
                    pl-3
                    text-amber-600
                  "
                >
                  <CheckIcon class="w-5 h-5" aria-hidden="true" />
                </span>
              </li>
            </ListboxOption>
          </ListboxOptions>
        </transition>
      </div>
    </Listbox>
  </div>
</template>

<script>
import { ref, watch, watchEffect } from "vue";
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
import axios from "axios";
import { CheckIcon, SelectorIcon } from "@heroicons/vue/solid";

export default {
  components: {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    CheckIcon,
    SelectorIcon,
  },

  setup(_, contaxt) {
    // categories
    const category = ref([]);
    const selectedCategory = ref([]);

    watchEffect(async () => {
      const res = await axios.get(`${process.env.VUE_APP_API}api/category`);
      res.data.allCategory.unshift({ id: "", name: "All Categories" });
      category.value = res.data.allCategory;
      selectedCategory.value = ref(category.value[0]);
    });

    watch(selectedCategory, () => {
      // Use emit function to send data
      contaxt.emit("changeCategory", selectedCategory.value.id);
    });

    return {
      category,
      selectedCategory,
    };
  },
};
</script>
