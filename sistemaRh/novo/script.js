window.onload = (function(){ 
    document.getElementById('ffuncionario').addEventListener("submit",function(ev){
       ev.preventDefault();
       const formData = new FormData(document.querySelector('form'))
       var nome = formData.get("nome");
       var sobrenome = formData.get('sobrenome');
       var cargo = formData.get('cargo');
       var salario = formData.get('salario');
       var dtnasc = formData.get('dtnasc');
       var email = formData.get('email');
       var telefone = formData.get('telefone');
       var estado = formData.get('estado');
       var cidade = formData.get('cidade');
       var dtcontratacao = formData.get('dtcontratacao');
       var sit = true;
       if (nome.length<3){
          alert("Digite um nome válido");
          sit = false;
       }
       if (telefone.length<8){
          alert("Preencha o campo telefone corretamente");
          sit = false;
       }
       if (sobrenome.length==0 || cargo.length<1 ||
          salario.length==0 || dtnasc.length==0 ||
          estado.length==0 || cidade.length==0 ||
          dtcontratacao.length==0){
             alert('Verifique os campos não preenchidos')
             sit = false;
       }
       if (sit==true){
          this.submit();
       }
       
    });
 });