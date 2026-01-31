import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import useFormField from "./form-field-context";

function FormMessage({ className, ...props }: ComponentProps<"p">) {
  const { error } = useFormField();

  return error ? (
    <p data-slot="form-message" className={cn("text-destructive", className)} {...props}>
      {error}
    </p>
  ) : null;
}

export default FormMessage;
