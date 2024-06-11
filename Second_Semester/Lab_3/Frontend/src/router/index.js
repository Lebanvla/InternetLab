import { createRouter, createWebHistory } from 'vue-router'
import MainPage from '../views/MainPage.vue'
import ProductPage from '../views/product_view/ProductPage.vue'
import BrandPage from '../views/brand_view/BrandPage.vue'
import BrandChangeForm from '../views/brand_view/BrandChangeForm.vue'
import ProductChangeForm from '../views/product_view/ProductChangeForm.vue'
import BrandCreateForm from '../views/brand_view/BrandCreateForm.vue'
import ProductCreateForm from '../views/product_view/ProductCreateForm.vue'
import SortedProductPage from '../views/product_view/SortedProductPage.vue'




const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: MainPage
    },
    {
      path: '/products',
      name: 'product_list',
      component: ProductPage
    },
    {
      path: '/products/:brand_id',
      name: 'sorted_product_list',
      component: SortedProductPage
    },

    {
      path: '/brands',
      name: 'brand_list',
      component: BrandPage
    },
    {
      path: '/brand_change_form/:id',
      name: 'brand_change_form',
      component: BrandChangeForm
    },
    {
      path: '/product_change_form/:id',
      name: 'product_change_form',
      component: ProductChangeForm
    },
    {
      path: '/brand_create_form',
      name: 'brand_create_form',
      component: BrandCreateForm
    },
    {
      path: '/product_create_form',
      name: 'product_create_form',
      component: ProductCreateForm
    }
  ]
})

export default router
