const getNewUrl = (added_url) =>{
  return "/search/"+added_url;
}

const searchCourse = (page_number = 1) => {
  let request_url = "/api/course/search.php?";
  let added_url = "";
  try {
    const title = document.getElementById("search").value;
    if (title.length > 0) {
      added_url += "title=" + title;
    }
  } catch (error) {
    console.log(error);
  }
  let page = "&page=" + page_number;
  added_url += page;
  let final_url = (request_url += added_url);
  window.history.pushState({path : getNewUrl(added_url)},'',getNewUrl(added_url));
  const xhr = new XMLHttpRequest();
  xhr.open("GET", final_url, true);
  xhr.onload = function () {
    if (this.status === 200) {
      let data = JSON.parse(this.responseText);
      let courses = data["courses"];
      let max_page = data["max_page"];
      let result_container = document.getElementById("result-container");
      let pagination = document.getElementById("pagination");
      let prev_index = page_number <= 1 ? 1 : page_number - 1
      result_container.innerHTML = "";
      pagination.innerHTML = "";
      courses.forEach((course) => {
        const formattedDate = new Date(course["release_date"]);
        const day = formattedDate.getDay();
        result_container.innerHTML += `<div class='card' style='cursor:pointer'>
                                <div class='card-top'>
                                    <img src='${course["image_path"]}' /?
                                </div>
                                <div class='card-info'>
                                    <div class='course-name'>
                                        <h2>${course["title"]}</h2>
                                    </div>
                                    <span class='lecturer'>${course["description"]}</span>
                                </div>
                                <div class='card-bottom flex-row'>
                                    <p>${day}</p>
                                </div>
                        </div>`;
      });
      if (page_number > 1) {
        prev_index = page_number - 1;
        pagination.innerHTML += `<a onclick='searchCourse(${prev_index})'>PREV</a>`;
      }
      for (let i = prev_index; i < page_number + 2; i++) {
        if (i == max_page) {
          break;
        }
        if (i === page_number) {
          pagination.innerHTML += `<a style='background-color:#9e51d8;color:white;'>${i}</a>`;
        } else {
          pagination.innerHTML += `<a id='pagination-number' onclick='searchCourse(${i})'>${i}</a>`;
        }
      }
      if (page_number < max_page - 2) {
        pagination.innerHTML += "<a>...</a>";
      }
      if (page_number === max_page) {
        pagination.innerHTML += `<a style='background-color:#9e51d8;color:white;'>${max_page}</a>`;
      } else {
        pagination.innerHTML += `<a onclick='searchCourse(${max_page})'>${max_page}</a>`;
      }

      if (page_number < max_page) {
        next_index = page_number +1;
        pagination.innerHTML += `<a onclick='searchCourse(${next_index})'>NEXT</a>`;
      }
    }
  };
  xhr.send();
};
