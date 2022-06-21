<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Switch from '@/Components/Switch.vue';
</script>

<template>
    <AppLayout title="List">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Me ({{ $page.props.user.name }})
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 sm:flex sm:items-center justify-end">
                <div class="mt-4 sm:mt-0 sm:flex-none">
                <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Add item
                </button>
                </div>
            </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
  <div class="flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">What did you do?</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Category</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Public</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">I spent 1000€/month to NGOs.</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <span class="bg-pink-100 text-pink-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
                        Contributions
                    </span>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <Switch/>
                </td>
                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                </td>
              </tr>
               <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">I didn't buy any additional tech after July 2022.</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
                        Consumption
                    </span>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <Switch/>
                </td>
                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                </td>
              </tr>
               <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">I didn't go on vacation more than 200kms away.</td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <span class="bg-orange-100 text-orange-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
                        Travelling
                    </span>
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <Switch/>
                </td>
                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                </td>
              </tr>

              <!-- More people... -->
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
