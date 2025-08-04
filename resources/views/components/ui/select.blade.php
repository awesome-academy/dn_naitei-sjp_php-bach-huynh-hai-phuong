<div x-data="{
        selectOpen: false,
        selectedItem: {{ $defaultItem ?: 'null' }},
        allItems: {{ $itemsJson }},
        selectableItems: [],
        selectableItemActive: null,
        selectId: $id('select'),
        selectKeydownValue: '',
        selectKeydownTimeout: 1000,
        selectKeydownClearTimeout: null,
        selectDropdownPosition: 'top',
        currentPage: 1,
        pageSize: 20,
        totalPages: 1,

        setPage(page) {
            if (page < 1 || page > this.totalPages) {
                return;
            }

            const start = (page - 1) * this.pageSize;
            this.currentPage = page;
            this.selectableItems = this.allItems.slice(start, start + this.pageSize);

            this.$refs.selectableItemsList.scrollTop = 0;
        },

        hasNextPage() {
            return this.currentPage < this.totalPages;
        },

        toNextPage() {
            this.setPage(this.currentPage + 1);
        },

        hasPreviousPage() {
            return this.currentPage > 1;
        },

        toPreviousPage() {
            this.setPage(this.currentPage - 1);
        },

        toPageIncludeSelectedItem() {
            if (this.selectedItem && this.selectedItem.value) {
                const index = this.allItems.findIndex(({ value }) => value === this.selectedItem.value);

                if (index !== -1) {
                    const pageIncludeSelectedItem = Math.ceil((index + 1) / this.pageSize);
                    this.setPage(pageIncludeSelectedItem)
                }
            }
        },

        selectableItemIsActive(item) {
            return this.selectableItemActive && this.selectableItemActive.value == item.value;
        },

        selectableItemActiveNext() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index < this.selectableItems.length - 1) {
                this.selectableItemActive = this.selectableItems[index + 1];
                this.selectScrollToActiveItem();
            }
        },

        selectableItemActivePrevious() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index > 0) {
                this.selectableItemActive = this.selectableItems[index - 1];
                this.selectScrollToActiveItem();
            }
        },

        selectScrollToActiveItem() {
            if (this.selectableItemActive) {
                const activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId);
                const newScrollPos = (activeElement.offsetTop + activeElement.offsetHeight) - this.$refs.selectableItemsList.offsetHeight;
                if (newScrollPos > 0) {
                    this.$refs.selectableItemsList.scrollTop = newScrollPos;
                } else {
                    this.$refs.selectableItemsList.scrollTop = 0;
                }
            }
        },

        selectKeydown(event) {
            if (event.keyCode >= 65 && event.keyCode <= 90) {
                this.selectKeydownValue += event.key;

                const selectedItemBestMatch = this.selectItemsFindBestMatch();
                if (selectedItemBestMatch) {
                    if (this.selectOpen) {
                        this.selectableItemActive = selectedItemBestMatch;
                        this.selectScrollToActiveItem();
                    } else {
                        this.selectedItem = this.selectableItemActive = selectedItemBestMatch;
                    }
                }

                if (this.selectKeydownValue !== '') {
                    clearTimeout(this.selectKeydownClearTimeout);
                    this.selectKeydownClearTimeout = setTimeout(() => {
                        this.selectKeydownValue = '';
                    }, this.selectKeydownTimeout);
                }
            }
        },

        selectItemsFindBestMatch() {
            const typedValue = this.selectKeydownValue.toLowerCase();
            let bestMatch = null;
            let bestMatchIndex = -1;

            for (let i = 0; i < this.selectableItems.length; i++) {
                const title = this.selectableItems[i].title.toLowerCase();
                const index = title.indexOf(typedValue);

                if (index > -1 && (bestMatchIndex === -1 || index < bestMatchIndex) && !this.selectableItems[i].disabled) {
                    bestMatch = this.selectableItems[i];
                    bestMatchIndex = index;
                }
            }

            return bestMatch;
        },

        selectPositionUpdate() {
            const selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top
                + this.$refs.selectButton.offsetHeight
                + parseInt(window.getComputedStyle(this.$refs.selectableItemsList).maxHeight);

            if (window.innerHeight < selectDropdownBottomPos) {
                this.selectDropdownPosition = 'top';
            } else {
                this.selectDropdownPosition = 'bottom';
            }
        }
    }"
    x-init="
        $watch('selectOpen', function() {
            if(!selectedItem){
                selectableItemActive = selectableItems[0];
            } else {
                selectableItemActive = selectedItem;
                toPageIncludeSelectedItem();
            }
            setTimeout(function(){
                selectScrollToActiveItem();
            }, 10);
            selectPositionUpdate();
            window.addEventListener('resize', (event) => { selectPositionUpdate(); });
        });

        totalPages = Math.ceil(allItems.length / pageSize);
        setPage(currentPage);
    "
    @keydown.escape="if(selectOpen){ selectOpen=false; }"
    @keydown.down="if(selectOpen){ selectableItemActiveNext(); } else { selectOpen=true; } event.preventDefault();"
    @keydown.up="if(selectOpen){ selectableItemActivePrevious(); } else { selectOpen=true; } event.preventDefault();"
    @keydown.enter="selectedItem=selectableItemActive; selectOpen=false;"
    @keydown="selectKeydown($event);"
    class="relative w-full"
>

    <input hidden name="{{ $name ?: 'undefined' }}" id="{{ $id ?: 'undefined' }}" :value="selectedItem ? selectedItem.value : null" @if ($required) required @endif/>
    <x-ui.button type="button" variant="outline" x-ref="selectButton" @click="selectOpen=!selectOpen" {{ $attributes->twMerge('w-full justify-between') }}>
        <span x-text="selectedItem ? selectedItem.title : '{{ $placeholder }}'" class="truncate" :class="{ 'text-muted-foreground': ! selectedItem, 'font-normal': selectedItem }">{{ $placeholder }}</span>
        <x-fas-up-down class="size-4 text-muted-foreground"/>
    </x-ui.button>

    <div x-show="selectOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100"
        @click.away="selectOpen = false"
        :class="{ 'bottom-0 mb-10' : selectDropdownPosition == 'top', 'top-0 mt-10' : selectDropdownPosition == 'bottom' }"
        class="absolute z-999 bg-popover text-popover-foreground rounded-md border shadow-md p-1 w-full grid gap-1"
        x-cloak
    >
        <div class="flex items-center justify-end p-1 border-b-border border-b relative">
            <p class="text-xs font-bold absolute top-1/2 right-1/2 translate-x-1/2 -translate-y-1/2">
                <span x-text="currentPage"></span> / <span x-text="totalPages"></span>
            </p>
            <div class="flex items-center gap-1">
                <x-ui.button ::disabled="!hasPreviousPage()" type="button" class="h-6" variant="ghost" size="icon" @click="toPreviousPage()">
                    <x-fas-arrow-left class="size-3"/>
                </x-ui.button>
                <x-ui.button ::disabled="!hasNextPage()" type="button" class="h-6" variant="ghost" size="icon" @click="toNextPage()">
                    <x-fas-arrow-right class="size-3"/>
                </x-ui.button>
            </div>
        </div>
        <ul
            x-ref="selectableItemsList"
            class="overflow-y-auto max-h-100 w-full"
        >

            <template x-for="item in selectableItems" :key="item.value">
                <li
                    @click="selectedItem=item; selectOpen=false; $refs.selectButton.focus();"
                    :id="item.value + '-' + selectId"
                    :data-disabled="item.disabled"
                    @mousemove="selectableItemActive=item"
                    :class="{ 'bg-accent text-accent-foreground': selectableItemIsActive(item)}"
                    class="focus:bg-accent focus:text-accent-foreground [&_svg:not([class*='text-'])]:text-muted-foreground relative flex w-full cursor-default items-center gap-2 rounded-sm py-1.5 pr-8 pl-2 text-sm outline-hidden select-none data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*='size-'])]:size-4 *:[span]:last:flex *:[span]:last:items-center *:[span]:last:gap-2"
                >
                    <span class="absolute right-2 flex size-3.5 items-center justify-center">
                        <x-fas-check x-show="selectedItem.value==item.value" class="size-4 text-muted-foreground"/>
                    </span>
                    <span x-text="item.title"></span>
                </li>
            </template>

        </ul>
    </div>

</div>
