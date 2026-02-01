import { Input } from "@narsil-cms/components/input";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function InputGroupInput({ className, ...props }: ComponentProps<typeof Input>) {
  return (
    <Input
      data-slot="input-group-control"
      className={cn(
        "flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 dark:bg-transparent",
        "focus-visible:ring-0",
        "disabled:bg-transparent dark:disabled:bg-transparent",
        "aria-invalid:ring-0",
        className,
      )}
      {...props}
    />
  );
}

export default InputGroupInput;
