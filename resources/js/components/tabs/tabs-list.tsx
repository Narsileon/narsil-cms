import { Tabs } from "@base-ui/react/tabs";
import { cn } from "@narsil-cms/lib/utils";

function TabsList({ className, ...props }: Tabs.List.Props) {
  return (
    <Tabs.List
      data-slot="tabs-list"
      className={cn(
        "inline-flex justify-start gap-2",
        "data-[orientation=vertical]:border-r",
        "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
        "data-[orientation=horizontal]:h-13",
        "data-[orientation=horizontal]:items-center data-[orientation=vertical]:items-start",
        "data-[orientation=horizontal]:overflow-x-auto data-[orientation=vertical]:overflow-y-auto",
        "data-[orientation=horizontal]:overflow-y-hidden data-[orientation=vertical]:overflow-x-hidden",
        "data-[orientation=vertical]:p-2",
        "data-[orientation=horizontal]:w-full data-[orientation=vertical]:min-w-40",
        "data-[orientation=vertical]:rounded-none",
        className,
      )}
      {...props}
    />
  );
}
export default TabsList;
