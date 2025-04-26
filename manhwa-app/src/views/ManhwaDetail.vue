<template>
    <div v-if="manhwa" class="manhwa-detail-container">
      <div class="detail-card">
        <div class="left-section">
          <img :src="manhwa.image_url || placeholderImage" :alt="manhwa.title" />
        </div>
        <div class="right-section">
          <h1 class="title">{{ manhwa.title }}</h1>
          <p class="synopsis">{{ manhwa.synopsis }}</p>
          <div class="tags">
            <span v-for="genre in manhwa.genre" :key="genre" class="tag genre">{{ genre }}</span>
            <span v-for="cat in manhwa.categories" :key="cat" class="tag category">{{ cat }}</span>
          </div>
          <div class="info">
            <p><strong>Status:</strong> {{ manhwa.status }}</p>
            <p><strong>Rating:</strong> {{ manhwa.rating }}</p>
            <p><strong>Authors:</strong> {{ manhwa.authors.join(', ') }}</p>
            <p><strong>Year:</strong> {{ manhwa.year }}</p>
            <p><strong>Chapters:</strong> {{ manhwa.chapters }}</p>
          </div>
        </div>
      </div>
    </div>
  
    <div v-else class="loading">
      Loading...
    </div>
  </template>
  
  <script>
  import axios from 'axios'
  
  export default {
    name: 'ManhwaDetail',
    data() {
      return {
        manhwa: null,
        placeholderImage: 'https://via.placeholder.com/250x350?text=No+Image'
      }
    },
    methods: {
      async fetchManhwa() {
        const id = this.$route.params.id
        try {
          const res = await axios.get(`http://localhost:8000/api/manhwa/${id}`)
          this.manhwa = res.data
        } catch (err) {
          console.error('Failed to fetch manhwa detail:', err)
        }
      }
    },
    mounted() {
      this.fetchManhwa()
    }
  }
  </script>
  
  <style scoped>
  .manhwa-detail-container {
    display: flex;
    justify-content: center;
    padding: 2rem;
  }
  
  .detail-card {
    display: flex;
    flex-wrap: wrap;
    background-color: #1e1e2f;
    border-radius: 12px;
    padding: 2rem;
    color: #f0f0f0;
    max-width: 1000px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    gap: 2rem;
  }
  
  .left-section img {
    width: 250px;
    border-radius: 10px;
    object-fit: cover;
  }
  
  .right-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  
  .synopsis {
    font-size: 1rem;
    color: #cfcfcf;
  }
  
  .tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }
  
  .tag {
    font-size: 0.85rem;
    padding: 0.3rem 0.6rem;
    border-radius: 20px;
    background-color: #3a3a55;
    color: #fff;
    white-space: nowrap;
  }
  
  .tag.genre {
    background-color: #5c7cfa;
  }
  
  .tag.category {
    background-color: #20c997;
  }
  
  .info p {
    margin: 0.3rem 0;
    font-size: 0.95rem;
  }
  
  .loading {
    text-align: center;
    margin-top: 3rem;
    color: #fff;
  }
  </style>
  