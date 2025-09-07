import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { Dialog as SheetPrimitive } from "radix-ui";
import { Icon } from "@narsil-cms/components/ui/icon";
import { useLabels } from "@narsil-cms/components/ui/labels";
import { VisuallyHiddenRoot } from "@narsil-cms/components/ui/visually-hidden";
import SheetOverlay from "./sheet-overlay";
import SheetPortal from "./sheet-portal";

type SheetContentProps = React.ComponentProps<typeof SheetPrimitive.Content> & {
  side?: "top" | "right" | "bottom" | "left";
};

function SheetContent({
  children,
  className,
  side = "right",
  ...props
}: SheetContentProps) {
  const { trans } = useLabels();

  return (
    <SheetPortal>
      <SheetOverlay />
      <SheetPrimitive.Content
        data-slot="sheet-content"
        className={cn(
          "bg-background fixed z-50 flex flex-col gap-4 shadow-lg transition ease-in-out",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "data-[state=closed]:duration-300 data-[state=open]:duration-300",
          side === "right" &&
            cn(
              "inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm",
              "data-[state=closed]:slide-out-to-right data-[state=open]:slide-in-from-right",
            ),
          side === "left" &&
            cn(
              "inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm",
              "data-[state=closed]:slide-out-to-left data-[state=open]:slide-in-from-left",
            ),
          side === "top" &&
            cn(
              "inset-x-0 top-0 h-auto border-b",
              "data-[state=closed]:slide-out-to-top data-[state=open]:slide-in-from-top",
            ),
          side === "bottom" &&
            cn(
              "inset-x-0 bottom-0 h-auto border-t",
              "data-[state=closed]:slide-out-to-bottom data-[state=open]:slide-in-from-bottom",
            ),
          className,
        )}
        {...props}
      >
        {children}
        <SheetPrimitive.Close
          className={cn(
            "ring-offset-background absolute top-4 right-4 rounded-md opacity-70 transition-opacity",
            "disabled:pointer-events-none",
            "focus:ring-ring focus:ring-2 focus:ring-offset-2 focus:outline-hidden",
            "hover:opacity-100",
            "data-[state=open]:bg-secondary",
          )}
        >
          <Icon className="size-4" name="x" />
          <VisuallyHiddenRoot>
            {trans("accessibility.close_sheet", "Close sheet")}
          </VisuallyHiddenRoot>
        </SheetPrimitive.Close>
      </SheetPrimitive.Content>
    </SheetPortal>
  );
}

export default SheetContent;
