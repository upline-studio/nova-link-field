<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <IndexField :field="field" :resource-name="resourceName"/>
    </template>
  </PanelItem>
</template>

<script>
import IndexField from "./IndexField.vue";

export default {
  components: {IndexField},
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
