async function fetchTodoLists() {
  const response = await fetch('http://localhost:8080/api/todolists', {
      method: 'GET',
      headers: {
          'Content-Type': 'application/json'
      }
  });
  if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
  }
  const todoLists = await response.json();
  const todoListContainer = document.getElementById('todo-list-container');
  todoListContainer.innerHTML = '';
  todoLists.forEach(todoList => {
      const div = document.createElement('div');
      div.className = 'todo-list';
      div.innerHTML = `
          <h2>${todoList.name}</h2>
          <ul id="todo-list-${todoList.id}">
              ${todoList.todos.map(todo => `<li>${todo.content}</li>`).join('')}
          </ul>
          <input type="text" id="todo-input-${todoList.id}" placeholder="New Todo">
          <button onclick="addTodo(${todoList.id})">Add Todo</button>
      `;
      todoListContainer.appendChild(div);
  });
}

async function addTodoList() {
  const name = document.getElementById('todo-list-input').value;
  const response = await fetch('http://localhost:8080/api/todolists', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({ name })
  });
  if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
  }
  document.getElementById('todo-list-input').value = '';
  fetchTodoLists();
}

async function addTodo(todoListId) {
  const content = document.getElementById(`todo-input-${todoListId}`).value;
  const response = await fetch(`http://localhost:8080/api/todos`, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({ content, todoListId })
  });
  if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
  }
  document.getElementById(`todo-input-${todoListId}`).value = '';
  fetchTodoLists();
}

document.addEventListener('DOMContentLoaded', fetchTodoLists);