import { FormElement, registry } from "@narsil-ui/components/form";
import { cn } from "@narsil-ui/lib/utils";
import type { FormData } from "@narsil-ui/types";
import { Fragment, type ComponentProps } from "react";

type FormPublishProps = ComponentProps<"div"> & {
  form: FormData;
};

function FormPublish({ className, form, ...props }: FormPublishProps) {
  return (
    <div className={cn("grid gap-2 border-b px-4 pt-2 pb-4", className)} {...props}>
      {form.steps.map((step, index) => {
        return (
          <Fragment key={index}>
            {step.elements?.map((element, index) => {
              return <FormElement {...element} registry={registry} key={index} />;
            })}
          </Fragment>
        );
      })}
    </div>
  );
}

export default FormPublish;
