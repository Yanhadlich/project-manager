import Swal from 'sweetalert2'

export function showSuccess(message: string, title:'Sucesso') {
    return Swal.fire({
        icon: 'success',
        title,
        text: message,
    })
}

export function showToast(message: string, icon:'success') {
    return Swal.fire({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        theme:"auto",
        icon: icon,
        title: message,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
}