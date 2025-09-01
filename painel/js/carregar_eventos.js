
// Receber o SELETOR da janela modal cadastrar
const cadastrarModal = new bootstrap.Modal(document.getElementById("cadastrarModal"));

// Receber o SELETOR da janela modal visualizar
const visualizarModal = new bootstrap.Modal(document.getElementById("visualizarModal"));

function carregarEventos() {


    var calendarEl = document.getElementById('calendar');

  // Recupere o valor do atributo data-target-pesq-events
  //const pesq_events = inputClienteId.getAttribute('data-target-pesq-events');


    var containerEl = document.getElementById('external-events-list');
    new FullCalendar.Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function (eventEl) {
        return {
          title: eventEl.innerText.trim()
        }
      }
    });


    var calendar = new FullCalendar.Calendar(calendarEl, {

      // Incluir o bootstrap 5
      themeSystem: 'bootstrap5',


      // Criar o cabeçalho do calendário
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },

      // Definir o idioma usado no calendário
      locale: 'pt-br',

      //PEGAR A DATA
      initialDate: '2024-10-26',

      // Permitir clicar nos nomes dos dias da semana 
      navLinks: true,

      // Permitir clicar e arrastar o mouse sobre um ou vários dias no calendário
      selectable: true,

      // Indicar visualmente a área que será selecionada antes que o usuário solte o botão do mouse para confirmar a seleção
      selectMirror: true,

      // Permitir arrastar e redimensionar os eventos diretamente no calendário.
      editable: true,

      // Número máximo de eventos em um determinado dia, se for true, o número de eventos será limitado à altura da célula do dia
      dayMaxEvents: true,

      // PERMITIR ARRASTAR OS EVENTOS PARA O CALENDÁRIO
      droppable: true,



      drop: function (arg) {
        // is the "remove after drop" checkbox checked?
        if (document.getElementById('drop-remove').checked) {
          // if so, remove the element from the "Draggable Events" list
          arg.draggedEl.parentNode.removeChild(arg.draggedEl);
        }
      },

      // AO ARRASTAR O EVENTO ENTRE DATAS
      eventDrop: function (event) {
        alert('event Drop')
      },


      // evento ao clicar no Evento
      eventClick: function (event) {

        // Apresentar os detalhes do evento
        document.getElementById("visualizarEvento").style.display = "block";
        document.getElementById("visualizarModalLabel").style.display = "block";

        // Ocultar o formulário editar do evento
        document.getElementById("editarEvento").style.display = "none";
        document.getElementById("editarModalLabel").style.display = "none";

        // Enviar para a janela modal os dados do evento
        document.getElementById("visualizar_id").innerText = event.event.id;
        document.getElementById("visualizar_title").innerText = event.event.title;
        document.getElementById("visualizar_obs").innerText = event.event.extendedProps.obs;
        document.getElementById("visualizar_user_id").innerText = event.event.extendedProps.user_id;
        document.getElementById("visualizar_name").innerText = event.event.extendedProps.name;
        document.getElementById("visualizar_email").innerText = event.event.extendedProps.email;



        document.getElementById("visualizar_start").innerText = event.event.start.toLocaleString();
        document.getElementById("visualizar_end").innerText = event.event.end !== null ? event.event.end.toLocaleString() : event.event.start.toLocaleString();


        // Enviar os dados do evento para o formulário editar
        document.getElementById("edit_id").value = event.event.id;
        document.getElementById("edit_title").value = event.event.title;
        document.getElementById("edit_obs").value = event.event.extendedProps.obs;
        document.getElementById("edit_start").value = converterData(event.event.start);
        document.getElementById("edit_end").value = event.event.end !== null ? converterData(event.event.end) : converterData(event.event.start);
        document.getElementById("edit_color").value = event.event.backgroundColor;


        // Abrir a janela modal visualizar
        visualizarModal.show();
      },

      // EVENTO AO ARRASTAR A DATA DO EVENTO
      eventResize: function (event) {
        alert('event Resize')
      },

      // evento ao clicar no Evento
      select:  function (event) {

        // Receber o SELETOR do campo usuário do formulário cadastrar
        var cadUserId = document.getElementById('cad_user_id');



        // Chamar a função para converter a data selecionada para ISO8601 e enviar para o formulário
        document.getElementById("cad_start").value = converterData(event.start);
        document.getElementById("cad_end").value = converterData(event.start);


        // Abrir a janela modal cadastrar
        cadastrarModal.show();

      },



      events: 'paginas/' + pag + "/listar.php",


    });
    calendar.render();



}