import axios from 'axios'
import {reactive} from "vue";


export default function useForm(options) {
  const method = options.method || 'post';

  const form = reactive({
    errors: {},
    errorMessage: undefined,
    loading: false,
    data: Object.assign({}, options.data),
    success: false,
    submit() {
      if (form.loading) return;
      form.loading = true;

      if (options.onStart) {
        options.onStart();
      }

      const data = form.data;

      // {
      //   data = form.data;
      // }

      axios({url: options.url, method, data})
        .then((response) => {
          form.errors = {};
          form.errorMessage = undefined;

          if (response.status < 300) {
            form.success = true;
            if (options.onSuccess && response) {
              options.onSuccess(response, form.data);
            }
          }
        })
        .catch((error) => {
          form.errors = {}
          form.errorMessage = undefined

          if (error.response) {
            if (error.response.status === 422) {
              if (error.response.data.errors) {
                Object.keys(error.response.data.errors).forEach((key) => {
                  form.errors[key] = error.response.data.errors[key][0]
                })
              }
            } else {
              form.errorMessage = error.response.data.message
            }
          }

          if (options.onError) {
            options.onError(error);
          }
        })
        .finally(() => {
          form.loading = false;
        });
    },
  });

  return form;
}
