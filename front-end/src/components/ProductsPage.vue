<template>
  <div class="container mx-auto">
    <div class="grid grid-rows-12 grid-flow-col gap-2">
      <!-- Sidebar with filters -->
      <div class="border row-span-3">
        <div class="sticky top-5 px-5 mt-6">
          <p class="text-500 capitalize text-center">All Filters</p>
          <!-- Filter by category -->
          <p class="mt-3">
            <CategoryFilter
              @changeCategory="changeCategory($event)"
              :products="products"
            />
          </p>
          <!-- Filter by availablity -->
          <p class="mt-5">
            <AvailableFilter @changeAvailability="changeAvailability($event)" />
          </p>
          <!-- Filter by min price -->
          <p class="mt-5">
            <PriceFilterMin
              @changePriceRangeMin="changePriceRangeMin($event)"
            />
          </p>
          <!-- Filter by max price -->
          <p class="mt-5">
            <PriceFilterMax
              @changePriceRangeMax="changePriceRangeMax($event)"
            />
          </p>
        </div>
      </div>

      <!-- Products list here -->
      <div class="border row-span-2 col-span-2">
        <div class="bg-white">
          <div class="max-w-2xl mx-auto pb-5 px-4 sm:pb-5 lg:max-w-7xl">
            <div
              v-if="loader"
              wire:loading
              class="
                h-screen
                z-50
                overflow-hidden
                opacity-75
                flex flex-col
                items-center
                justify-center
              "
            >
              <div
                class="
                  loader
                  ease-linear
                  rounded-full
                  border-4 border-t-4 border-gray-700
                  h-12
                  w-12
                  mb-4
                "
              ></div>
              <h2 class="text-center text-black text-xl font-semibold">
                Loading...
              </h2>
              <p class="w-1/3 text-center text-black">
                This may take a few seconds, please don't close this page.
              </p>
            </div>
            <div v-if="totalRecord > 0">
              <div
                class="
                  mt-6
                  grid grid-cols-1
                  gap-y-10 gap-x-6
                  sm:grid-cols-2
                  lg:grid-cols-4
                  xl:gap-x-8
                "
              >
                <!-- Product card with loop -->
                <div
                  v-for="product in products"
                  :key="product.id"
                  class="group relative"
                >
                  <div
                    class="
                      w-full
                      min-h-80
                      bg-gray-200
                      aspect-w-1 aspect-h-1
                      rounded-md
                      overflow-hidden
                      group-hover:opacity-75
                      lg:h-80 lg:aspect-none
                    "
                  >
                    <img
                      src="https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg"
                      :alt="product.name"
                      class="
                        w-full
                        h-full
                        object-center object-cover
                        lg:w-full lg:h-full
                      "
                    />
                  </div>
                  <div class="mt-4 flex justify-between">
                    <div>
                      <h3 class="text-sm text-gray-700">
                        <a class="capitalize">
                          <span aria-hidden="true" class="absolute inset-0" />
                          {{ product.name }}
                        </a>
                      </h3>
                      <p class="mt-1 text-sm text-gray-500 capitalize">
                        {{ product.category.name }}
                      </p>
                      <p class="mt-1 text-sm text-gray-500 capitalize wrap-1">
                        {{ product.description }}
                      </p>
                      <p class="mt-1 text-sm text-gray-500 capitalize">
                        {{
                          product.available === 1 ? "In Stock" : "Out Of Stock"
                        }}
                      </p>
                    </div>
                    <p class="text-sm font-medium text-gray-900">
                      ${{ product.price }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="" h-12 w-12 mb-4>
              <div class="overflow-hidden sm:rounded-lg pb-8">
                <div class="border-t border-gray-200 text-center pt-8">
                  <h3 class="text-4xl font-medium py-8">
                    Ooooops...! No Products were Found.
                  </h3>
                  <p class="text-1xl pb-8 px-12 font-medium">
                    Sorry,we couldn't find any product that matches your search
                    category. Why not try to broaden your search if possible, or
                    use the links on the left of this page to search similar
                    category products.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- Pagination here -->
          <div class="my-2" v-if="totalRecord > limit">
            <div class="flex justify-center">
              <div class="py-2">
                <nav class="block">
                  <ul class="flex pl-0 rounded list-none flex-wrap">
                    <li>
                      <a
                        v-if="offset > 1"
                        class="
                          pointer
                          first:ml-0
                          text-xs
                          font-semibold
                          flex
                          w-8
                          h-8
                          mx-1
                          p-0
                          rounded-full
                          items-center
                          justify-center
                          leading-tight
                          relative
                          border border-solid border-gray-500
                          bg-blue
                          text-gray-500
                        "
                        @click="changePagination(offset - 1)"
                      >
                        <i class="fas fa-chevron-left -ml-px"></i>
                      </a>
                      <span
                        v-else
                        class="
                          first:ml-0
                          text-xs
                          font-semibold
                          flex
                          w-8
                          h-8
                          mx-1
                          p-0
                          rounded-full
                          items-center
                          justify-center
                          leading-tight
                          relative
                          border border-solid border-gray-500
                          bg-white
                          backdrop-blur-none
                          text-gray-500
                        "
                      >
                        <i class="fas fa-chevron-left -ml-px"></i>
                      </span>
                    </li>
                    <!-- paginate 1 -->
                    <li>
                      <a
                        v-if="totalRecord > limit * offset"
                        class="
                          pointer
                          first:ml-0
                          text-xs
                          font-semibold
                          flex
                          w-8
                          h-8
                          mx-1
                          p-0
                          rounded-full
                          items-center
                          justify-center
                          leading-tight
                          relative
                          border border-solid border-gray-500
                          bg-blue
                          text-gray-500
                        "
                        @click="changePagination(offset + 1)"
                      >
                        <i class="fas fa-chevron-right -mr-px"></i>
                      </a>
                      <span
                        v-else
                        class="
                          pointer
                          first:ml-0
                          text-xs
                          font-semibold
                          flex
                          w-8
                          h-8
                          mx-1
                          p-0
                          rounded-full
                          items-center
                          justify-center
                          leading-tight
                          relative
                          border border-solid border-gray-500
                          bg-white
                          text-gray-500
                        "
                      >
                        <i class="fas fa-chevron-right -mr-px"></i>
                      </span>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watchEffect } from "vue";
import axios from "axios";
import CategoryFilter from "./CategoryFilter.vue";
import AvailableFilter from "./AvailableFilter.vue";
import PriceFilterMin from "./PriceFilterMin.vue";
import PriceFilterMax from "./PriceFilterMax.vue";

export default {
  components: {
    CategoryFilter,
    AvailableFilter,
    PriceFilterMin,
    PriceFilterMax,
  },
  setup() {
    const category = ref("");
    const availability = ref("");
    const min = ref("");
    const max = ref("");
    const products = ref([]);
    const offset = ref(1);
    const totalRecord = ref(0);
    const limit = 20;
    const loader = ref(true);

    // Fetch data from api
    watchEffect(async () => {
      loader.value = true;
      const result =
        await axios.get(`${process.env.VUE_APP_API}api/product?page=${offset.value}
          &category=${category.value}&min=${min.value}
          &max=${max.value}&availability=${availability.value}&limit=${limit}`);
      if (result && result?.data?.data.length > 0) {
        products.value = result.data.data;
        totalRecord.value = result.data.totalRecord;
        loader.value = false;
      } else {
        loader.value = false;
        products.value = [];
        totalRecord.value = 0;
      }
    });

    // Update category
    const changeCategory = (catId) => {
      offset.value = 1;
      category.value = catId;
    };

    // Update availability
    const changeAvailability = (avlId) => {
      offset.value = 1;
      availability.value = avlId;
    };

    // Update min range
    const changePriceRangeMin = (minVal) => {
      offset.value = 1;
      min.value = minVal;
    };

    // Update max range
    const changePriceRangeMax = (maxVal) => {
      offset.value = 1;
      max.value = maxVal;
    };

    // Handle pagination
    const changePagination = (value) => {
      offset.value = value;
    };

    return {
      products,
      category,
      min,
      max,
      offset,
      limit,
      changeCategory,
      availability,
      changeAvailability,
      changePriceRangeMin,
      changePriceRangeMax,
      changePagination,
      totalRecord,
      loader,
    };
  },
};
</script>

<style scoped>
.wrap-1 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.bg-blue {
  background: #50535c;
  color: #fff;
}
</style>
