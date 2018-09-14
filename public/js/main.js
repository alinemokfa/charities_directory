const charities = document.getElementById('charities');

if(charities) {
    charities.addEventListener('click', e =>{
        if(e.target.className === 'btn btn-danger delete-charity') {
            if(confirm('Are you sure?')){
                const id = e.target.getAttribute('data-id');

                fetch(`/charity/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
            }
        }
    });
}