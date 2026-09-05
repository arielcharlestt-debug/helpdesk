<div 
    class="fixed bottom-4 right-4 flex flex-col gap-4" 
    x-data="toasty"
    x-show="hasEntries">
    <template 
        x-for="(entry, index) in entries" 
        x-bind:key="index"
        >
        <div
            xyz="fade-in bottom-5 duration-2"
            x-transition:enter="xyz-in"
            x-transition:leave="xyz-out"
            class="bg-frost-0 p-4 shrink-0 w-96 max-w-[calc(100vw-2rem)] flex gap-2 border-1 border-solid border-frost-300 justify-start items-center focus-within:border-primary shadow-lg hover:shadow-xl transition-shadow">
            
            <div class="grow flex flex-col gap-2 outline-none" tabindex="-1">
                <div class="w-full flex justify-between items-center">
                    <h2 class="text-sm font-semibold font-primary" x-text="entry.title"></h2>
                    <button class="shrink-0 ml-auto text-primary hover:bg-frost-100 rounded transition-colors p-1" x-bind:data-index="index" x-on:click="dismiss">
                        <?php echo wp_documentation_svg('square-rounded-x-filled'); ?>
                    </button>
                </div>

                <p class="text-sm break-all">
                    <code x-html="entry.message"></code>
                </p>
            </div>
        </div>
    </template>
</div>