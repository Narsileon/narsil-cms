import { cn } from "@narsil-cms/lib/utils";
import { useId } from "react";
import { FormItemContext } from "./form-item-context";

type FormItemProps = React.ComponentProps<"div"> & {};

function FormItem({ className, ...props }: FormItemProps) {
  const id = useId();

  return (
    <FormItemContext.Provider value={{ id }}>
      <div
        data-slot="form-item"
        className={cn("flex flex-col gap-2", className)}
        {...props}
      />
    </FormItemContext.Provider>
  );
}

export default FormItem;
