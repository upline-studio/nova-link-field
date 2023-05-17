import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-nova-link-field', IndexField)
  app.component('detail-nova-link-field', DetailField)
  app.component('form-nova-link-field', FormField)
})
