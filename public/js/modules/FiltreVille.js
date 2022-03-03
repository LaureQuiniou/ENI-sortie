
/**
 *@property {HTMLFormElement} form
 */

export class FiltreVille {

    /**
     *
     * @param {HTMLElement|null}element
     */
    constructor(element) {
        if (element === null) {
        }else {
            this.form = element.querySelector('.js-filter-villes');
            this.bindEvents();
            this.addLieu();
        }
    }


    /**
     * Ajoute les comportements aux elements
     */

    bindEvents() {

        let url=(window.location.href).replace(/(modifierSortie\/){1}\d+/,"cree_une_sortie")
        document.querySelector('.form-ville').addEventListener('keyup', e => {
            e.preventDefault();
            console.log(url)
            const data= '&ville='+ document.querySelector('.form-ville').value;
            this.loadVille(url, data);
        })

        document.querySelector('.form-ville').addEventListener('input', e =>{
            e.preventDefault();
            const words = document.querySelector('.form-ville').value.split(' ');
            const lieu = 1
            const data = '&ville=' + words[1] + '&lieu=' + lieu
            this.loadLieu(url, data);
        })

        document.querySelector('.form-lieu').addEventListener('keyup', e =>{
            e.preventDefault();
            const words = document.querySelector('.form-ville').value.split(' ');
            const lieu = document.querySelector('.form-lieu').value
            const data = '&ville=' + words[1] + '&lieu=' + lieu
            this.loadLieu(url, data);
        })

        document.querySelector('.form-lieu').addEventListener('blur', e =>{
            e.preventDefault();
            const data = '&lieu=' + document.querySelector('.form-lieu').value
            this.loadRue(url, data);
        })

    }

    async loadRue(url, data){
        const response = await fetch(url + '?ajax=1' + data  , {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
        })
        if (response.status >= 200 && response.status < 300) {
            const resp= await response.json()
            document.querySelector('.div-rue').innerHTML = resp.content
        } else {
            console.error(response)
        }
    }

    async loadLieu(url, data) {
        const response = await fetch(url + '?ajax=1' + data  , {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
        })
        if (response.status >= 200 && response.status < 300) {
            const resp= await response.json()
            document.querySelector('.div-lieu').innerHTML = resp.content
        } else {
            console.error(response)
        }

    }

    async loadVille(url, data) {
        console.log(url + '?ajax=1' + data)
            const response = await fetch(url + '?ajax=1' + data  , {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
            if (response.status >= 200 && response.status < 300) {
                const data = await response.json()
                console.log(data)
                document.querySelector('.div-ville').innerHTML = data.content

            } else {
                console.error(response)
            }
        }

}