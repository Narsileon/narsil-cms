import { cn } from "@narsil-cms/lib/utils";

import useFormField from "./form-field-context";

type FormMessageProps = React.ComponentProps<"p">;

function FormMessage({ className, ...props }: FormMessageProps) {
  const { error } = useFormField();

  return error ? (
    <p
      data-slot="form-message"
      className={cn("text-destructive", className)}
      {...props}
    >
      {error}
    </p>
  ) : null;
}

export default FormMessage;
