import { createRouter, createWebHistory } from 'vue-router'
import MainPage from '../views/MainPage.vue'
import ProductPage from '../views/ProductPage.vue'
import BrandPage from '../views/BrandPage.vue'
import BrandChangeForm from '../views/BrandChangeForm.vue'

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
      path: '/brands',
      name: 'brand_list',
      component: BrandPage
    },
    {
      path: '/brand_change_form',
      name: 'brand_change_form',
      component: BrandChangeForm
    }

  ]
})

export default router
