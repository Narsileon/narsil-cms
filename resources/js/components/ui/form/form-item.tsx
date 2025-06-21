import { cn } from "@/lib/utils";
import { createContext, useId } from "react";

type FormItemContextValue = {
  id: string;
};

const FormItemContext = createContext<FormItemContextValue>(
  {} as FormItemContextValue,
);

export type FormItemProps = React.ComponentProps<"div"> & {};

function FormItem({ className, ...props }: FormItemProps) {
  const id = useId();

  return (
    <FormItemContext.Provider value={{ id }}>
      <div
        data-slot="form-item"
        className={cn("grid gap-2", className)}
        {...props}
      />
    </FormItemContext.Provider>
  );
}

export default FormItem;
