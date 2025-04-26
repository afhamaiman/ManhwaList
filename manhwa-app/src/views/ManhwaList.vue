<template>
    <div class="manhwa-container">
      <h1 class="title">📚 All Manhwa</h1>
  
      <div class="controls">
        <input type="text" v-model="searchQuery" placeholder="Search by title" />
        <select v-model="selectedGenre">
          <option value="">All Genres</option>
          <option v-for="genre in availableGenres" :key="genre">{{ genre }}</option>
        </select>
        <select v-model="selectedStatus">
          <option value="">All Status</option>
          <option>Ongoing</option>
          <option>Completed</option>
        </select>
        <select v-model="selectedRating">
          <option value="">All Ratings</option>
          <option>Highly Recommended</option>
          <option>Recommended</option>
          <option>Good</option>
          <option>Decent</option>
        </select>
      </div>
  
      <div v-if="loading" class="loading">Loading manhwas...</div>
  
      <div class="manhwa-grid">
        <router-link
          v-for="manhwa in paginatedManhwas"
          :key="manhwa.id"
          :to="`/manhwa/${manhwa.id}`"
          class="manhwa-card"
        >
          <div class="img-wrapper">
            <img :src="manhwa.image_url || placeholderImage" :alt="manhwa.title" />
          </div>
          <div class="info">
            <h3 class="title">{{ manhwa.title }}</h3>
            <div class="tags">
              <span class="tag" v-for="tag in manhwa.genre" :key="tag">{{ tag }}</span>
            </div>
            <p class="status">{{ manhwa.status }} • {{ manhwa.rating }}</p>
          </div>
        </router-link>
      </div>
  
      <div class="pagination">
        <button @click="currentPage--" :disabled="currentPage === 1">Previous</button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button @click="currentPage++" :disabled="currentPage === totalPages">Next</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios'
  
  export default {
    name: 'ManhwaList',
    data() {
      return {
        allManhwas: [],
        searchQuery: '',
        selectedGenre: '',
        selectedStatus: '',
        selectedRating: '',
        currentPage: 1,
        perPage: 10,
        loading: true,
        placeholderImage: 'https://via.placeholder.com/250x350?text=No+Image'
      }
    },
    computed: {
      filteredManhwas() {
        return this.allManhwas.filter(manhwa => {
          const matchesTitle = manhwa.title.toLowerCase().includes(this.searchQuery.toLowerCase())
          const matchesGenre = this.selectedGenre ? manhwa.genre.includes(this.selectedGenre) : true
          const matchesStatus = this.selectedStatus ? manhwa.status === this.selectedStatus : true
          const matchesRating = this.selectedRating ? manhwa.rating === this.selectedRating : true
          return matchesTitle && matchesGenre && matchesStatus && matchesRating
        })
      },
      paginatedManhwas() {
        const start = (this.currentPage - 1) * this.perPage
        return this.filteredManhwas.slice(start, start + this.perPage)
      },
      totalPages() {
        return Math.ceil(this.filteredManhwas.length / this.perPage)
      },
      availableGenres() {
        const genres = new Set()
        this.allManhwas.forEach(m => m.genre.forEach(g => genres.add(g)))
        return [...genres]
      }
    },
    methods: {
      async fetchManhwas() {
        this.loading = true
        try {
          const res = await axios.get('http://localhost:8000/api/manhwa')
          this.allManhwas = res.data.data
        } catch (err) {
          console.error('Failed to fetch manhwas', err)
        } finally {
          this.loading = false
        }
      }
    },
    mounted() {
      this.fetchManhwas()
    }
  }
  </script>
  
  <style scoped>
  /* ... styling sama seperti sebelum ni ... */
  </style>
  
  
  <style scoped>
  .manhwa-container {
    padding: 2rem;
    font-family: 'Inter', sans-serif;
    background-color: var(--bg);
    color: var(--text);
  }
  
  .controls {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }
  
  input,
  select {
    padding: 0.5rem;
    border: 1px solid var(--border);
    border-radius: 6px;
    background-color: var(--input-bg);
    color: var(--text);
  }
  
  .manhwa-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
  }
  
  .manhwa-card {
    background-color: var(--card-bg);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    text-align: center;
    padding: 10px;
  }
  
  .manhwa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
  }
  
  .img-wrapper {
    overflow: hidden;
    border-radius: 8px;
    position: relative;
  }
  
  .img-wrapper img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease, filter 0.3s ease;
  }
  
  .manhwa-card:hover img {
    transform: scale(1.1);
  }
  
  .info .title {
    margin-top: 10px;
    font-size: 1rem;
    font-weight: bold;
    color: var(--text);
  }
  
  .tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    justify-content: center;
    margin: 0.5rem 0;
  }
  
  .tag {
    background-color: var(--accent);
    color: white;
    padding: 2px 6px;
    font-size: 0.75rem;
    border-radius: 4px;
  }
  
  .status {
    font-size: 0.85rem;
    color: var(--text-muted);
  }
  
  .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
  }
  
  .pagination button {
    padding: 0.5rem 1rem;
    background-color: var(--accent);
    border: none;
    color: white;
    border-radius: 6px;
    cursor: pointer;
  }
  
  .pagination button:disabled {
    background-color: var(--disabled);
    color: var(--text-muted);
    cursor: not-allowed;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .manhwa-grid {
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
  
    .img-wrapper img {
      height: 200px;
    }
  }
  
  @media (max-width: 480px) {
    .title {
      font-size: 1.5rem;
    }
  
    input,
    select {
      width: 100%;
    }
  }
  </style>
  