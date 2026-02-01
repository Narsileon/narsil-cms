import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function InputGroup({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="input-group"
      role="group"
      className={cn(
        "group/input-group",
        "relative flex h-9 w-full min-w-0 items-center rounded-md border border-input transition-colors outline-none dark:bg-input/30",
        "has-[[data-slot][aria-invalid=true]]:border-destructive has-[[data-slot][aria-invalid=true]]:ring-[3px] has-[[data-slot][aria-invalid=true]]:ring-destructive/20 dark:has-[[data-slot][aria-invalid=true]]:ring-destructive/40",
        "has-[[data-slot=input-group-control]:focus-visible]:border-shine",
        "has-[>[data-align=block-end]]:[&>input]:pt-3",
        "has-[>[data-align=block-end]]:h-auto has-[>[data-align=block-end]]:flex-col",
        "has-[>[data-align=block-start]]:[&>input]:pb-3",
        "has-[>[data-align=block-start]]:h-auto has-[>[data-align=block-start]]:flex-col",
        "has-[>[data-align=inline-end]]:[&>input]:pr-1.5",
        "has-[>[data-align=inline-start]]:[&>input]:pl-1.5",
        "has-[>textarea]:h-auto",
        "has-disabled:bg-input/50 has-disabled:opacity-50 dark:has-disabled:bg-input/80",
        "in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0",
        className,
      )}
      {...props}
    />
  );
}

export default InputGroup;
