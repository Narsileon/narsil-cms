import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";

const navigationMenuTriggerVariants = cva(
  cn(
    "group/navigation-menu-trigger",
    "inline-flex h-9 w-max items-center justify-center rounded-lg bg-background px-2.5 py-1.5 font-medium transition-all outline-none",
    "data-open:bg-muted/50",
    "data-open:focus:bg-muted",
    "data-open:hover:bg-muted",
    "data-popup-open:bg-muted/50",
    "data-popup-open:hover:bg-muted",
    "disabled:pointer-events-none disabled:opacity-50",
    "focus-visible:ring-ring/50 focus-visible:outline-1",
    "focus:bg-muted focus-visible:ring-[3px]",
    "hover:bg-muted",
  ),
);

export default navigationMenuTriggerVariants;
