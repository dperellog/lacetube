<template>
    <div class="star-rating">
      <span v-for="i in maxRating"
            v-bind:class="{ 'star': true, 'filled': i <= currentRating, 'hovered': i <= hoveredRating }"
            v-bind:key="i"
            v-on:mouseover="setHoveredRating(i)"
            v-on:mouseleave="setHoveredRating(currentRating)"
            v-on:click="setCurrentRating(i)"><i class="fa-solid fa-star"></i>
      </span>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      maxRating: {
        type: Number,
        required: true
      },
      currentRating: {
        type: Number,
        required: true
      }
    },
    emits: ['puntuacio'],
    data() {
      return {
        hoveredRating: 0
      };
    },
    methods: {
      setHoveredRating(rating) {
        this.hoveredRating = rating;
      },
      setCurrentRating(rating) {
        this.hoveredRating = 0;
        this.$emit('puntuacio', rating);
      }
    }
  };
  </script>
  
  <style>
  .star {
    font-size: 2em;
    color: #D5D5D5;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
  }
  .star.filled {
    color: #FF9F1C;
  }
  .star.hovered {
    color: #FF9F1C;
  }
  </style>
  