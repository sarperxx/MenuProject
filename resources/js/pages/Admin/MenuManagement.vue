<script setup lang="ts">
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

interface Menu {
  id: number;
  name: string;
  slug: string;
  start_time: string;
  end_time: string;
  description?: string;
}
interface Category {
  id: number;
  name: string;
  menus?: Menu[];
}
interface MenuItem {
  id: number;
  name: string;
}

defineProps<{
  menus: Menu[];
  categories: Category[];
  items: MenuItem[];
}>();

const showMenuForm = ref(false);
const isEditMenu = ref(false);
const editMenuId = ref<number|null>(null);
const menuForm = useForm({
  name: '',
  slug: '',
  start_time: '',
  end_time: '',
  description: '',
});

function openAddMenu() {
  showMenuForm.value = true;
  isEditMenu.value = false;
  editMenuId.value = null;
  menuForm.reset();
}
function openEditMenu(menu: Menu) {
  showMenuForm.value = true;
  isEditMenu.value = true;
  editMenuId.value = menu.id;
  menuForm.name = menu.name;
  menuForm.slug = menu.slug;
  menuForm.start_time = menu.start_time;
  menuForm.end_time = menu.end_time;
  menuForm.description = menu.description || '';
}
function closeMenuForm() {
  showMenuForm.value = false;
  menuForm.reset();
  editMenuId.value = null;
}
function submitMenuForm() {
  if (isEditMenu.value && editMenuId.value) {
    menuForm.transform(data => ({ ...data, _method: 'put' })).post(route('admin.menu-management.menus.update', editMenuId.value), {
      onSuccess: closeMenuForm,
      forceFormData: true,
    });
  } else {
    menuForm.post(route('admin.menu-management.menus.store'), {
      onSuccess: closeMenuForm,
      forceFormData: true,
    });
  }
}
function deleteMenu(menu: Menu) {
  if (confirm(`Delete menu '${menu.name}'?`)) {
    router.delete(route('admin.menu-management.menus.destroy', menu.id));
  }
}

const showCategoryForm = ref(false);
const isEditCategory = ref(false);
const editCategoryId = ref<number|null>(null);
const categoryForm = useForm({
  name: '',
  menu_id: '',
});

function openAddCategory() {
  showCategoryForm.value = true;
  isEditCategory.value = false;
  editCategoryId.value = null;
  categoryForm.reset();
}
function openEditCategory(cat: Category) {
  showCategoryForm.value = true;
  isEditCategory.value = true;
  editCategoryId.value = cat.id;
  categoryForm.name = cat.name;
  categoryForm.menu_id = cat.menus && cat.menus.length > 0 ? String(cat.menus[0].id) : '';
}
function closeCategoryForm() {
  showCategoryForm.value = false;
  categoryForm.reset();
  editCategoryId.value = null;
}
function submitCategoryForm() {
  if (isEditCategory.value && editCategoryId.value) {
    categoryForm.transform(data => ({ ...data, _method: 'put' })).post(route('admin.menu-management.categories.update', editCategoryId.value), {
      onSuccess: closeCategoryForm,
      forceFormData: true,
    });
  } else {
    categoryForm.post(route('admin.menu-management.categories.store'), {
      onSuccess: closeCategoryForm,
      forceFormData: true,
    });
  }
}
function deleteCategory(cat: Category) {
  if (confirm(`Delete category '${cat.name}'?`)) {
    router.delete(route('admin.menu-management.categories.destroy', cat.id));
  }
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Admin Menu Management</h1>
    <div class="mb-6">
      <div class="flex items-center justify-between mb-2">
        <h2 class="text-lg font-semibold">Menus</h2>
        <button class="px-3 py-1 bg-blue-600 text-white rounded" @click="openAddMenu">Add Menu</button>
      </div>
      <table class="w-full border text-sm">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Slug</th>
            <th class="p-2 border">Start</th>
            <th class="p-2 border">End</th>
            <th class="p-2 border">Description</th>
            <th class="p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="menu in menus" :key="menu.id">
            <td class="p-2 border">{{ menu.name }}</td>
            <td class="p-2 border">{{ menu.slug }}</td>
            <td class="p-2 border">{{ menu.start_time }}</td>
            <td class="p-2 border">{{ menu.end_time }}</td>
            <td class="p-2 border">{{ menu.description }}</td>
            <td class="p-2 border">
              <button class="px-2 py-1 bg-yellow-500 text-white rounded mr-2" @click="openEditMenu(menu)">Edit</button>
              <button class="px-2 py-1 bg-red-600 text-white rounded" @click="deleteMenu(menu)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Menu Form Modal -->
    <div v-if="showMenuForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-md relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-black" @click="closeMenuForm">&times;</button>
        <h2 class="text-xl font-bold mb-4">{{ isEditMenu ? 'Edit' : 'Add' }} Menu</h2>
        <form @submit.prevent="submitMenuForm">
          <div class="mb-3">
            <label class="block mb-1 font-medium">Name</label>
            <input v-model="menuForm.name" type="text" class="w-full border rounded px-3 py-2" />
            <div v-if="menuForm.errors.name" class="text-red-600 text-sm mt-1">{{ menuForm.errors.name }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Slug</label>
            <input v-model="menuForm.slug" type="text" class="w-full border rounded px-3 py-2" />
            <div v-if="menuForm.errors.slug" class="text-red-600 text-sm mt-1">{{ menuForm.errors.slug }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Start Time</label>
            <input v-model="menuForm.start_time" type="time" class="w-full border rounded px-3 py-2" />
            <div v-if="menuForm.errors.start_time" class="text-red-600 text-sm mt-1">{{ menuForm.errors.start_time }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">End Time</label>
            <input v-model="menuForm.end_time" type="time" class="w-full border rounded px-3 py-2" />
            <div v-if="menuForm.errors.end_time" class="text-red-600 text-sm mt-1">{{ menuForm.errors.end_time }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Description</label>
            <textarea v-model="menuForm.description" class="w-full border rounded px-3 py-2"></textarea>
            <div v-if="menuForm.errors.description" class="text-red-600 text-sm mt-1">{{ menuForm.errors.description }}</div>
          </div>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">{{ isEditMenu ? 'Save Changes' : 'Add Menu' }}</button>
        </form>
      </div>
    </div>
    <div class="mb-6">
      <div class="flex items-center justify-between mb-2">
        <h2 class="text-lg font-semibold">Menu Categories</h2>
        <button class="px-3 py-1 bg-blue-600 text-white rounded" @click="openAddCategory">Add Category</button>
      </div>
      <table class="w-full border text-sm">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Menu</th>
            <th class="p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cat in categories" :key="cat.id">
            <td class="p-2 border">{{ cat.name }}</td>
            <td class="p-2 border">{{ cat.menus && cat.menus.length > 0 ? cat.menus[0].name : 'No menu' }}</td>
            <td class="p-2 border">
              <button class="px-2 py-1 bg-yellow-500 text-white rounded mr-2" @click="openEditCategory(cat)">Edit</button>
              <button class="px-2 py-1 bg-red-600 text-white rounded" @click="deleteCategory(cat)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Category Form Modal -->
    <div v-if="showCategoryForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-md relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-black" @click="closeCategoryForm">&times;</button>
        <h2 class="text-xl font-bold mb-4">{{ isEditCategory ? 'Edit' : 'Add' }} Category</h2>
        <form @submit.prevent="submitCategoryForm">
          <div class="mb-3">
            <label class="block mb-1 font-medium">Name</label>
            <input v-model="categoryForm.name" type="text" class="w-full border rounded px-3 py-2" />
            <div v-if="categoryForm.errors.name" class="text-red-600 text-sm mt-1">{{ categoryForm.errors.name }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Menu</label>
            <select v-model="categoryForm.menu_id" class="w-full border rounded px-3 py-2">
              <option value="">Select menu</option>
              <option v-for="menu in menus" :key="menu.id" :value="menu.id">{{ menu.name }}</option>
            </select>
            <div v-if="categoryForm.errors.menu_id" class="text-red-600 text-sm mt-1">{{ categoryForm.errors.menu_id }}</div>
          </div>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">{{ isEditCategory ? 'Save Changes' : 'Add Category' }}</button>
        </form>
      </div>
    </div>
  </div>
</template> 