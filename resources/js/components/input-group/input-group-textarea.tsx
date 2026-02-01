import { Textarea } from "@narsil-cms/components/textarea";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function InputGroupTextarea({ className, ...props }: ComponentProps<"textarea">) {
  return (
    <Textarea
      data-slot="input-group-control"
      className={cn(
        "flex-1 resize-none rounded-none border-0 bg-transparent py-2 shadow-none ring-0 dark:bg-transparent",
        "focus-visible:ring-0",
        "disabled:bg-transparent dark:disabled:bg-transparent",
        "aria-invalid:ring-0",
        className,
      )}
      {...props}
    />
  );
}

export default InputGroupTextarea;
