import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/Home.vue'
import ManhwaList from '../views/ManhwaList.vue'
import ManhwaDetail from '../views/ManhwaDetail.vue' // import file baru

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/manhwa', name: 'ManhwaList', component: ManhwaList },
  { path: '/manhwa/:id', name: 'ManhwaDetail', component: ManhwaDetail } // new route
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
