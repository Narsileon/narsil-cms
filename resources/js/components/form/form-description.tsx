import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type FormDescriptionProps = ComponentProps<"p"> & {};

function FormDescription({ className, ...props }: FormDescriptionProps) {
  return (
    <p
      data-slot="form-description"
      className={cn("text-muted-foreground", className)}
      {...props}
    />
  );
}

export default FormDescription;
