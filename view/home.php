<img class="background" src="./source/img/background.jpg" />
<div id="main-wrap" class="w3-center">
	<h1 class="w3-center">
		Lost & Found
	</h1>
	<div class="w3-padding">
		<label>
			<input
				id="search-input"
				class="glass hover"
				type="text"
				placeholder="Search"
				autocomplete="off"
			/>
		</label>
	</div>
	<div class="item-container">
		<div v-for="(item, index) in lostItems" v-on:click="showInfo" v-bind:data-idx="index" class="item glass hover w3-round flex col">
			<div class="info-date t-gray">{{ item.dateAgo }}일 전</div>
			<div class="w3-left-align w3-large">{{ item.title }}</div>
			<div class="img">
				<img class="w3-round" v-bind:src="'./source/img/' + item.imgName" />
			</div>
		</div>
	</div>
	<div id="pagination">
		<div class="inline-flex col glass relative">
			<div id="to-first-page" class="page-btns center hover">
				<span><i class="las la-angle-double-up"></i></span>
			</div>
			<div v-for="btn in page.btns" v-on:click="loadPage" class="page-btns center hover">
				<span v-if="0 < btn && btn <= page.num">{{ btn }}</span>
			</div>
			<div id="to-last-page" class="page-btns center hover">
				<span><i class="las la-angle-double-down"></i></span>
			</div>
		</div>
	</div>
	<transition name="bounce">
		<div id="item-info" v-if="info.show">
			<div class="glass">
				<div class="absolute w3-xlarge" style="top: -36px; right: 12px;" v-on:click="hideInfo">
					<span><i class="las la-times"></i></span>
				</div>
				<div class="img">
					<img v-bind:src="'./source/img/' + lostItems[info.idx].imgName" />
				</div>
			</div>
		</div>
	</transition>
	<div id="next-page" class="w3-center margin-top-12 t-gray pointer">
		다음 페이지
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
	function main() {
		let app = new Vue({
			el: '#main-wrap',
			data: {
				lostItems: [],
				page: {
					current: 1,
					num: 0,
					btns: ['', '', '', '', ''],
				},
				info: {
					show: false,
					idx: 0
				}
			},
			methods: {
				loadPage: function(event) {
					let target = Number(event.target.innerText);
					if(0 < target&& target <= this.page.num) {
						loadPage(target);
					}
				},
				showInfo: function(event) {
					this.info.idx = Number(event.currentTarget.dataset.idx);
					this.info.show = true;
				},
				hideInfo: function(event) {
					this.info.show = false;
				}
			}
		});
		
		function loadPage(page = 1, query = '') {
			let xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function () {
				if (xhr.readyState === XMLHttpRequest.DONE) {
					if (xhr.status === 200) {
						let json = JSON.parse(String(xhr.responseText));
						
						app.lostItems = [...json.lostItems];
						if(app.page.num != json.page.num || app.page.current != json.page.current) {
							app.page.num = json.page.num;
							app.page.current = json.page.current;
							
							app.page.btns[0] = app.page.current - 2;
							app.page.btns[1] = app.page.current - 1;
							app.page.btns[2] = app.page.current;
							app.page.btns[3] = app.page.current + 1;
							app.page.btns[4] = app.page.current + 2;
						}
						window.scrollTo(0, 0);
					} else {
						alert(xhr.responseText);
					}
				}
			};

			xhr.open('GET', './model/item_info.php?page=' + page + '&query=' + query);
			xhr.send();
		}

		function get(query) {
			return document.querySelector(query);
		}
		function getAll(query) {
			return document.querySelectorAll(query);
		}

		function isElementUnderBottom(elem, triggerDiff) {
			const { top } = elem.getBoundingClientRect();
			const { innerHeight } = window;
			return top > innerHeight + (triggerDiff || 0);
		}

		function handleScroll() {
			const elems = getAll('.item');
			elems.forEach((elem) => {
				if (isElementUnderBottom(elem, -20)) {
					elem.style.opacity = '0';
					elem.style.transform = 'translateY(70px)';
				} else {
					elem.style.opacity = '1';
					elem.style.transform = 'translateY(0px)';
				}
			});
		}
		
		loadPage();
		
		get('#next-page').addEventListener('click', (event)=>{loadPage(app.page.current+1)});
		get('#to-first-page').addEventListener('click', (event)=>{loadPage(1)});
		get('#to-last-page').addEventListener('click', (event)=>{loadPage(app.page.num)});

		window.addEventListener('scroll', handleScroll);
	}

	main();
</script>