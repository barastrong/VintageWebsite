<template>
  <div>
    <WebHeader/>
    <router-view></router-view>
    <!-- <WebFooter/> -->
  </div>
</template>

<script>
import WebHeader from './components/Headers/WebHeader.vue';
// import WebFooter from './components/Footers/WebFooter.vue';

export default {
  components: {
    WebHeader,
    // WebFooter
  }
}
</script>