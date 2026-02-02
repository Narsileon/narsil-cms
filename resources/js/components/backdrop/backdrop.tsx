import { cn } from "@narsil-cms/lib/utils";
import { ComponentProps } from "react";

function Backdrop({ className, ...props }: ComponentProps<"div">) {
  return (
    <div
      data-slot="backdrop"
      className={cn(
        "fixed inset-0 isolate z-50 duration-100",
        "data-closed:animate-out data-closed:fade-out-0",
        "data-open:animate-in data-open:fade-in-0",
        "supports-backdrop-filter:backdrop-blur-xs",
        className,
      )}
      {...props}
    />
  );
}

export default Backdrop;
