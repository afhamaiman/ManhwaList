<template>
  <div class="home-container">
    <!-- Daily Recommendation Carousel -->
    <h2 class="section-title">🌟 Daily Recommendation</h2>
    <div class="carousel" v-if="dailyRecommendations.length">
      <div class="carousel-slide">
        <div
          class="carousel-content"
          :class="{ sliding: isSliding }"
          @transitionend="onTransitionEnd"
        >
          <img
            :src="dailyRecommendations[currentSlide].image_url || placeholderImage"
            :alt="dailyRecommendations[currentSlide].title"
          />
          <div class="carousel-info">
            <router-link
              :to="`/manhwa/${dailyRecommendations[currentSlide].id}`"
              class="carousel-title-link"
            >
              <h3>{{ dailyRecommendations[currentSlide].title }}</h3>
            </router-link>
            <p>{{ dailyRecommendations[currentSlide].synopsis }}</p>
            <div class="tags">
              <span v-for="tag in dailyRecommendations[currentSlide].genre" :key="tag" class="tag">{{ tag }}</span>
              <span v-for="cat in dailyRecommendations[currentSlide].categories" :key="cat" class="tag">{{ cat }}</span>
            </div>
          </div>
        </div>
        <div class="carousel-controls">
          <button @click="prevSlide">⟨</button>
          <button @click="nextSlide">⟩</button>
        </div>
      </div>
    </div>

    <!-- Random Picks -->
    <h2 class="section-title">🎲 Random Picks</h2>
    <div class="manhwa-grid">
      <router-link
        v-for="manhwa in randomManhwas"
        :key="manhwa.id"
        :to="`/manhwa/${manhwa.id}`"
        class="manhwa-card"
      >
        <img :src="manhwa.image_url || placeholderImage" :alt="manhwa.title" />
        <div class="info">
          <h3>{{ manhwa.title }}</h3>
          <p class="meta">{{ manhwa.genre.join(', ') }}</p>
          <p class="status">{{ manhwa.status }} • {{ manhwa.rating }}</p>
        </div>
      </router-link>
    </div>
    <div class="refresh-button">
      <button @click="generateRandomManhwas">🔁 Refresh</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Home',
  data() {
    return {
      allManhwas: [],
      dailyRecommendations: [],
      randomManhwas: [],
      currentSlide: 0,
      placeholderImage: 'https://via.placeholder.com/250x350?text=No+Image',
      autoSlideInterval: null,
      isSliding: false
    }
  },
  methods: {
    async fetchManhwas() {
      try {
        const res = await axios.get('http://localhost:8000/api/manhwa')
        this.allManhwas = res.data.data
        this.generateDailyRecommendations()
        this.generateRandomManhwas()
      } catch (err) {
        console.error('Error fetching manhwas:', err)
      }
    },
    generateDailyRecommendations() {
      const shuffled = [...this.allManhwas].sort(() => 0.5 - Math.random())
      this.dailyRecommendations = shuffled.slice(0, 5)
      this.currentSlide = 0
    },
    generateRandomManhwas() {
      const shuffled = [...this.allManhwas].sort(() => 0.5 - Math.random())
      this.randomManhwas = shuffled.slice(0, 5)
    },
    nextSlide() {
      this.isSliding = true
      setTimeout(() => {
        this.currentSlide = (this.currentSlide + 1) % this.dailyRecommendations.length
      }, 300)
    },
    prevSlide() {
      this.isSliding = true
      setTimeout(() => {
        this.currentSlide =
          (this.currentSlide - 1 + this.dailyRecommendations.length) %
          this.dailyRecommendations.length
      }, 300)
    },
    onTransitionEnd() {
      this.isSliding = false
    },
    startAutoSlide() {
      this.autoSlideInterval = setInterval(() => {
        this.nextSlide()
      }, 5000)
    },
    stopAutoSlide() {
      clearInterval(this.autoSlideInterval)
    }
  },
  mounted() {
    this.fetchManhwas()
    this.startAutoSlide()
  },
  beforeUnmount() {
    this.stopAutoSlide()
  }
}
</script>



<style scoped>
.home-container {
  padding: 2rem;
  font-family: 'Inter', sans-serif;
  background-color: var(--bg);
  color: var(--text);
}

.section-title {
  margin: 1rem 0;
  font-size: 1.8rem;
}

/* Carousel */
.carousel {
  position: relative;
  margin-bottom: 3rem;
}

.carousel-slide {
  display: flex;
  flex-direction: column;
}

.carousel-content {
  display: flex;
  gap: 2rem;
  align-items: center;
  transition: transform 0.3s ease, opacity 0.3s ease;
}

.carousel-content.sliding {
  transform: translateX(-30px);
  opacity: 0.6;
}

.carousel-content img {
  width: 250px;
  height: 350px;
  object-fit: cover;
  border-radius: 12px;
}

.carousel-info {
  flex: 1;
}

.carousel-info h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
}

.carousel-info p {
  margin-bottom: 0.5rem;
}

.tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem;
}

.tag {
  background-color: var(--accent);
  color: white;
  padding: 0.25rem 0.5rem;
  border-radius: 6px;
  font-size: 0.8rem;
}

/* Carousel buttons */
.carousel-controls {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}

.carousel-controls button {
  background: var(--accent);
  border: none;
  padding: 0.5rem 1rem;
  margin: 0 1rem;
  color: white;
  font-size: 1.2rem;
  border-radius: 6px;
  cursor: pointer;
}

/* Random Grid */
.manhwa-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 1.5rem;
}

.manhwa-card {
  background-color: var(--card-bg);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
  cursor: pointer;
}

.manhwa-card:hover {
  transform: scale(1.05);
}

.manhwa-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
}

.info {
  padding: 0.75rem;
}

.info h3 {
  margin: 0;
  font-size: 1rem;
}

.meta,
.status {
  font-size: 0.85rem;
  color: var(--text-muted);
}

/* Refresh Button */
.refresh-button {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.refresh-button button {
  padding: 0.6rem 1.2rem;
  background-color: var(--accent);
  border: none;
  color: white;
  font-size: 1rem;
  border-radius: 8px;
  cursor: pointer;
}

/* Responsive */
@media (max-width: 768px) {
  .carousel-content {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .carousel-content img {
    width: 200px;
    height: 280px;
  }

  .manhwa-grid {
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  }
}
</style>
