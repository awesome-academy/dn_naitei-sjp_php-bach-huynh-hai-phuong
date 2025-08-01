<div x-data="{
        selectOpen: false,
        selectedItem: {{ $defaultItem }},
        selectableItems: {{ $itemsJson }},
        selectableItemActive: null,
        selectId: $id('select'),
        selectKeydownValue: '',
        selectKeydownTimeout: 1000,
        selectKeydownClearTimeout: null,
        selectDropdownPosition: 'bottom',
        selectableItemIsActive(item) {
            return this.selectableItemActive && this.selectableItemActive.value==item.value;
        },
        selectableItemActiveNext(){
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if(index < this.selectableItems.length-1){
                this.selectableItemActive = this.selectableItems[index+1];
                this.selectScrollToActiveItem();
            }
        },
        selectableItemActivePrevious(){
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if(index > 0){
                this.selectableItemActive = this.selectableItems[index-1];
                this.selectScrollToActiveItem();
            }
        },
        selectScrollToActiveItem(){
            if(this.selectableItemActive){
                activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId)
                newScrollPos = (activeElement.offsetTop + activeElement.offsetHeight) - this.$refs.selectableItemsList.offsetHeight;
                if(newScrollPos > 0){
                    this.$refs.selectableItemsList.scrollTop=newScrollPos;
                } else {
                    this.$refs.selectableItemsList.scrollTop=0;
                }
            }
        },
        selectKeydown(event){
            if (event.keyCode >= 65 && event.keyCode <= 90) {

                this.selectKeydownValue += event.key;
                selectedItemBestMatch = this.selectItemsFindBestMatch();
                if(selectedItemBestMatch){
                    if(this.selectOpen){
                        this.selectableItemActive = selectedItemBestMatch;
                        this.selectScrollToActiveItem();
                    } else {
                        this.selectedItem = this.selectableItemActive = selectedItemBestMatch;
                    }
                }

                if(this.selectKeydownValue != ''){
                    clearTimeout(this.selectKeydownClearTimeout);
                    this.selectKeydownClearTimeout = setTimeout(() => {
                        this.selectKeydownValue = '';
                    }, this.selectKeydownTimeout);
                }
            }
        },
        selectItemsFindBestMatch(){
            typedValue = this.selectKeydownValue.toLowerCase();
            var bestMatch = null;
            var bestMatchIndex = -1;
            for (var i = 0; i < this.selectableItems.length; i++) {
                var title = this.selectableItems[i].title.toLowerCase();
                var index = title.indexOf(typedValue);
                if (index > -1 && (bestMatchIndex == -1 || index < bestMatchIndex) && !this.selectableItems[i].disabled) {
                    bestMatch = this.selectableItems[i];
                    bestMatchIndex = index;
                }
            }
            return bestMatch;
        },
        selectPositionUpdate(){
            selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top + this.$refs.selectButton.offsetHeight + parseInt(window.getComputedStyle(this.$refs.selectableItemsList).maxHeight);
            if(window.innerHeight < selectDropdownBottomPos){
                this.selectDropdownPosition = 'top';
            } else {
                this.selectDropdownPosition = 'bottom';
            }
        }
    }"
    x-init="
        $watch('selectOpen', function(){
            if(!selectedItem){
                selectableItemActive=selectableItems[0];
            } else {
                selectableItemActive=selectedItem;
            }
            setTimeout(function(){
                selectScrollToActiveItem();
            }, 10);
            selectPositionUpdate();
            window.addEventListener('resize', (event) => { selectPositionUpdate(); });
        });
    "
    @keydown.escape="if(selectOpen){ selectOpen=false; }"
    @keydown.down="if(selectOpen){ selectableItemActiveNext(); } else { selectOpen=true; } event.preventDefault();"
    @keydown.up="if(selectOpen){ selectableItemActivePrevious(); } else { selectOpen=true; } event.preventDefault();"
    @keydown.enter="selectedItem=selectableItemActive; selectOpen=false;"
    @keydown="selectKeydown($event);"
    class="relative w-full">
    <input hidden name="{{ $name ?: 'undefined' }}" id="{{ $id ?: 'undefined' }}" :value="selectedItem ? selectedItem.value : null" required="{{ $required }}"/>
    <x-ui.button type="button" variant="outline" x-ref="selectButton" @click="selectOpen=!selectOpen" {{ $attributes->twMerge('w-full justify-between') }}>
        <span x-text="selectedItem ? selectedItem.title : '{{ $placeholder }}'" class="truncate" :class="{ 'text-muted-foreground': ! selectedItem, 'font-normal': selectedItem }">{{ $placeholder }}</span>
        <x-fas-up-down class="size-4 text-muted-foreground"/>
    </x-ui.button>

    <ul x-show="selectOpen"
        x-ref="selectableItemsList"
        @click.away="selectOpen = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100"
        :class="{ 'bottom-0 mb-10' : selectDropdownPosition == 'top', 'top-0 mt-10' : selectDropdownPosition == 'bottom' }"
        class="absolute bg-popover text-popover-foreground rounded-md border shadow-md p-1 w-full max-h-100 overflow-y-auto"
        x-cloak>

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
