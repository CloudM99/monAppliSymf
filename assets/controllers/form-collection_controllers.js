import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["collectionContainer"];

    static values = {
        index: Number,
        prototype: String,
    };

    addCollectionElement(event) {
        console.log("Adding collection element");
        const item = document.createElement('li');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        this.collectionContainerTarget.appendChild(item);
        this.indexValue++;
        this.addTagFormDeleteLink(item);
    }

    addTagFormDeleteLink(item) {
        console.log("Adding delete button to item:", item);
        const removeFormButton = document.createElement('button');
        removeFormButton.innerText = 'Supprimer';
        removeFormButton.type='button';
        removeFormButton.classList.add('btn', 'btn-danger', 'ml-2');

        item.append(removeFormButton);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
        });
    }

    connect() {
        console.log("Controller connected");
        // Ajoute le bouton "Supprimer" aux distributeurs existants lors de l'initialisation
        this.collectionContainerTarget.querySelectorAll('li').forEach((item) => {
            if (!item.querySelector('button[type="button"]')) { // Vérifie si le bouton existe déjà
                this.addTagFormDeleteLink(item);
            }
        });
    }
}
