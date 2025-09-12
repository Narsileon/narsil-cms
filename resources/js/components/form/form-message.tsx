import { cn } from "@narsil-cms/lib/utils";

import useFormField from "./form-field-context";

type FormMessageProps = React.ComponentProps<"p">;

function FormMessage({ className, ...props }: FormMessageProps) {
  const { error } = useFormField();

  if (!error) {
    return null;
  }

  return (
    <p
      data-slot="form-message"
      className={cn("text-sm text-destructive", className)}
      {...props}
    >
      {error}
    </p>
  );
}

export default FormMessage;
