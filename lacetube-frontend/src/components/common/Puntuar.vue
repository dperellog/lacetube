<template>
    <div class="star-puntuacio">
      <span v-for="i in puntuacioMaxima"
            v-bind:class="{ 'star': true, 'filled': i <= puntuacioActual, 'hovered': i <= puntuacioRatoli }"
            v-bind:key="i"
            v-on:mouseover="ratoliEstrelles(i)"
            v-on:mouseleave="ratoliEstrelles(puntuacioActual)"
            v-on:click="setPuntuacioActual(i)"><i class="fa-solid fa-star"></i>
      </span>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      puntuacioMaxima: {
        type: Number,
        required: true
      },
      puntuacioActual: {
        type: Number,
        required: true
      }
    },
    emits: ['puntuacio'],
    data() {
      return {
        puntuacioRatoli: 0
      };
    },
    methods: {
      ratoliEstrelles(puntuacio) {
        this.puntuacioRatoli = puntuacio;
      },
      setPuntuacioActual(puntuacio) {
        this.puntuacioRatoli = 0;
        this.$emit('puntuacio', puntuacio);
      }
    }
  };
  </script>
  
  <style scoped>
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
  