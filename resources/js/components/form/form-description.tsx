import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type FormDescriptionProps = ComponentProps<"p">;

function FormDescription({ className, ...props }: FormDescriptionProps) {
  return (
    <p data-slot="form-description" className={cn("text-muted-foreground", className)} {...props} />
  );
}

export default FormDescription;
