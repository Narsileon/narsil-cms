import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function FormDescription({ className, ...props }: ComponentProps<"p">) {
  return (
    <p data-slot="form-description" className={cn("text-muted-foreground", className)} {...props} />
  );
}

export default FormDescription;
