<template>
  <!-- Max price input box -->
  <div class="mb-3 pt-0">
    <input
      type="number"
      placeholder="Max Price"
      v-model="maxPrice"
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
    />
  </div>
</template>

<script>
import { ref, watch } from "vue";
export default {
  setup(_, contaxt) {
    const maxPrice = ref("");
    // Send user enterd max value in parant component
    watch(maxPrice, () => {
      // Use emit function to send data
      contaxt.emit("changePriceRangeMax", maxPrice.value);
    });
    return {
      maxPrice,
    };
  },
};
</script>

<style scoped>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
