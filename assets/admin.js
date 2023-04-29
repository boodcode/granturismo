document.querySelectorAll("td.field-boolean input[type=checkbox]").forEach((node) =>
  node.addEventListener("click", () => location.reload())
)

// Initialize Filepond on the file input field

import * as FilePond from 'filepond';
import 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js';


const operationId =  document.body.id.split('-').at(-1)

const inputElement = document.querySelector('.ea-vich-file input[type="file"]');
const pond = FilePond.create(inputElement, {
  allowFileTypeValidation: true,
  acceptedFileTypes: ['application/zip'],
  labelFileTypeNotAllowed: 'Le type de fichier n\'est pas autorisé',
  allowMultiple: false,
  labelIdle: 'Déposez votre zip ici ou <span class="filepond--label-action">Parcourir</span>',
  server: {
    url: 'upload/'+operationId,
    process: {
      method: 'POST',
      onload: (response) => {
        // Handle successful upload
        console.log('onload', response);
      },
      onerror: (response) => {
        // Handle failed upload
        console.log('onerror', response);
      },
      onprogress: (event) => {
        // Update the progress bar here
        const percent = (event.loaded / event.total) * 100;
        console.log('onprogress', percent);
      },
    },
  },
});


