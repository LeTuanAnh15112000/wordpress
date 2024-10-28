import $ from "jquery";
class Search {
  constructor() {
    //lấy phần tử icon search
    //lấy nút đóng khung search
    //search overlay
    this.result = $("#search-overlay__result");
    this.openSearch = $(".search-trigger");
    this.closeSearch = $(".search-overlay__close");
    this.overlay = $(".search-overlay");
    this.isOpen = false;
    this.timing;
    this.searchItem = $("#search-term");
    this.event();
    this.spinnerVisible = false;
    this.previousValue = "";
  }

  event() {
    this.openSearch.on("click", this.openOverlay.bind(this));
    this.closeSearch.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatch.bind(this));
    this.searchItem.on("keyup", this.typingLogic.bind(this));
  }

  keyPressDispatch(e) {
    if (e.keyCode == 83 && !this.isOpen) {
      this.openOverlay();
    }
    if (e.keyCode == 27 && this.isOpen) {
      this.closeOverlay();
    }
  }

  typingLogic() {
    if(this.previousValue != this.searchItem.val()) {
      clearTimeout(this.timing);
      if(this.searchItem.val()) {
        if(!this.spinnerVisible) {
          this.result.html("<div class='spinner-loader'></div>");
          this.spinnerVisible = true;
        }
        this.timing = setTimeout(this.getResults.bind(this), 2000);
      } else {
        this.result.html("");
        this.spinnerVisible = false;
      }       
    }
    this.previousValue = this.searchItem.val();
  }

  getResults() {
    $.getJSON(universityData.root_url + "/wp-json/university/v1/schools?term=" + this.searchItem.val(), results => {
    this.result.html(`
    <div class="row">
      <div class="one-third">
        <h2 class="search-overlay__section-title">General Information</h2>
        ${results.general_info.length ? '<ul class="link-list min-list">' : '<p>General Information no match with search</p>'}     
        ${results.general_info.map(item => `<li><a href='${item.permalink}'>${item.title} ${item.postType == "post" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
        ${results.general_info.length ? ' </ul>' : ''}
      </div>
      <div class="one-third">
        <h2 class="search-overlay__section-title">Programs</h2>
        ${results.programmes.length ? '<ul class="link-list min-list">' : '<p>Programs no match with search</p>'}     
        ${results.programmes.map(item => `<li><a href='${item.permalink}'>${item.title} ${item.postType == "programmes" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
        ${results.programmes.length ? ' </ul>' : ''}

        <h2 class="search-overlay__section-title">Professors</h2>
        ${results.professors.length ? '<ul class="link-list min-list">' : '<p>Professions Information no match with search</p>'}     
        ${results.professors.map(item => `<li><a href='${item.permalink}'>${item.title} ${item.postType == "professors" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
        ${results.professors.length ? ' </ul>' : ''}
      </div>
      <div class="one-third">
        <h2 class="search-overlay__section-title">Events</h2>
        ${results.event.length ? '<ul class="link-list min-list">' : '<p>event no match with search</p>'}     
        ${results.event.map(item => `<li><a href='${item.permalink}'>${item.title} ${item.postType == "event" ? `by ${item.authorName}</a></li>` : ``}`).join('')}
        ${results.event.length ? ' </ul>' : ''}
      </div>
    </div>
  `)
  this.isSpinnerVisible = false
})

  // getResults() {
  //   $.when(
  //     $.getJSON(universityData.root_url + "/wp-json/wp/v2/posts?search=" + this.searchItem.val()),
  //     $.getJSON(universityData.root_url + "/wp-json/wp/v2/pages?search=" + this.searchItem.val())
  //   ).then((posts, pages) => {
  //     var combineResults = posts[0].concat(pages[0]);
  //     this.result.html(`
  //       <h2 class="search-overlay__section-title">General Information</h2>
  //       ${combineResults.length ? '<ul class="link-list min-list">' : '<p>General Information no match with search</p>'}     
  //       ${combineResults.map(item => `<li><a href='${item.link}'>${item.title.rendered} ${item.type == "post" ? `by ${item.authorName}` : ""}</a></li>`).join('')}
  //       ${combineResults.length ? ' </ul>' : ''}
  //     `);
  //     this.spinnerVisible = false;
  //   }, () => {
  //     this.result.html("<p>Error Unexpeted in search!!!</p>");
  //   })
  }

  openOverlay() {
    this.overlay.addClass("search-overlay--active");
    this.isOpen = true;
    $("body").addClass("body-no-scroll");
  }

  closeOverlay() {
    this.overlay.removeClass("search-overlay--active");
    this.isOpen = false;
    $("body").removeClass("body-no-scroll");
  }
}
export default Search;
