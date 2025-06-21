import { cn } from "@/lib/utils";
import { createContext, useId } from "react";

type FormItemContextValue = {
  id: string;
};

const FormItemContext = createContext<FormItemContextValue>(
  {} as FormItemContextValue,
);

export type FormItemProps = React.ComponentProps<"div"> & {
  orientation?: "horizontal" | "vertical";
};

function FormItem({
  className,
  orientation = "vertical",
  ...props
}: FormItemProps) {
  const id = useId();

  return (
    <FormItemContext.Provider value={{ id }}>
      <div
        data-slot="form-item"
        data-orientation={orientation}
        className={cn(
          "flex gap-2",
          "data-[orientation=horizontal]:flex-row data-[orientation=vertical]:flex-col",
          className,
        )}
        {...props}
      />
    </FormItemContext.Provider>
  );
}

export default FormItem;
