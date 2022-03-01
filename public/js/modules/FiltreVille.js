
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
        }
    }

    /**
     * Ajoute les comportements aux elements
     */

    bindEvents() {
        document.querySelector('.form-ville').addEventListener('keyup', e => {
            e.preventDefault();
            //const ville = document.getElementById("sortie_lieu_ville").value
            this.loadUrl(window.location.href, document.querySelector('.form-ville').value)
        })
    }

    async loadUrl(url, data) {
        /*
        const xhttp = new XMLHttpRequest()
        console.log('ici f')
        xhttp.onload=function () {
            if (xhttp.status >= 200 && xhttp.status < 300) {
                const resp= xhttp.response
                console.log(resp)
                //this.ville.innerHTML = "res
            }
        }
        xhttp.open("GET", url + '?ajax=1&data=' + data , true)
        //xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        xhttp.send()
    */


            const response = await fetch(url + '?ajax=1&data=' + data  , {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
                console.log(response)
            if (response.status >= 200 && response.status < 300) {
                const data = await response.json()
                console.log (data.content)
                document.querySelector('.div-ville').innerHTML = data.content

            } else {
                console.error(response)
            }
        }

}