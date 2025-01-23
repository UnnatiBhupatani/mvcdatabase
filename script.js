const apiURL = "https://jsonplaceholder.typicode.com/users"; // Example API
let data = [];
let editIndex = null;
let currentPage = 1;
const rowsPerPage = 5; // Number of rows per page

// Fetch and display data
async function fetchData() {
  const response = await fetch(apiURL);
  data = await response.json();
  displayData();
  setupPagination();
}

// Display data in the table for the current page
function displayData() {
  const dataTable = document.getElementById("dataTable");
  dataTable.innerHTML = "";

  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const currentData = data.slice(startIndex, endIndex);

  currentData.forEach((item, index) => {
    dataTable.innerHTML += `
      <tr>
        <td>${startIndex + index + 1}</td>
        <td>${item.name}</td>
        <td>${item.email}</td>
        <td>
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#dataModal" onclick="editData(${startIndex + index})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="deleteData(${startIndex + index})">Delete</button>
        </td>
      </tr>
    `;
  });
}

// Add or update data
document.getElementById("dataForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;

  if (editIndex === null) {
    // Add new data
    data.push({ name, email });
  } else {
    // Update existing data
    data[editIndex].name = name;
    data[editIndex].email = email;
    editIndex = null;
  }

  resetForm();
  setupPagination();
  displayData();
  bootstrap.Modal.getInstance(document.getElementById("dataModal")).hide(); // Close modal
});

// Edit data
function editData(index) {
  document.getElementById("name").value = data[index].name;
  document.getElementById("email").value = data[index].email;
  editIndex = index;
}

// Delete data
function deleteData(index) {
  data.splice(index, 1);
  setupPagination();
  displayData();
}

// Reset form
function resetForm() {
  document.getElementById("dataForm").reset();
  editIndex = null;
}

// Pagination logic
function setupPagination() {
  const paginationContainer = document.getElementById("pagination");
  paginationContainer.innerHTML = "";

  const totalPages = Math.ceil(data.length / rowsPerPage);

  const prevButton = `<button class="btn btn-secondary me-2" onclick="changePage('prev')" ${currentPage === 1 ? 'disabled' : ''}>Previous</button>`;
  const nextButton = `<button class="btn btn-secondary ms-2" onclick="changePage('next')" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;

  let pageButtons = "";
  for (let i = 1; i <= totalPages; i++) {
    pageButtons += `<button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'}" onclick="changePage(${i})">${i}</button>`;
  }

  paginationContainer.innerHTML = prevButton + pageButtons + nextButton;
}

function changePage(page) {
  const totalPages = Math.ceil(data.length / rowsPerPage);

  if (page === 'prev' && currentPage > 1) {
    currentPage--;
  } else if (page === 'next' && currentPage < totalPages) {
    currentPage++;
  } else if (typeof page === 'number') {
    currentPage = page;
  }

  displayData();
  setupPagination();
}

// Initialize
fetchData();
