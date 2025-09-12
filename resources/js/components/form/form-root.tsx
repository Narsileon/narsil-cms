import { VisitOptions } from "@inertiajs/core";

import { cn } from "@narsil-cms/lib/utils";

import useForm from "./form-context";

type FormRootProps = React.ComponentProps<"form"> & {
  options?: Omit<VisitOptions, "data">;
};

function FormRoot({ className, options, ...props }: FormRootProps) {
  const { action, id, isDirty, method, post, transform } = useForm();

  function onSubmit(event?: React.FormEvent) {
    event?.preventDefault();

    switch (method) {
      case "patch":
      case "put":
        transform?.((data) => ({
          ...data,
          _dirty: isDirty,
          _method: method,
        }));
        post?.(action, { ...options, forceFormData: true });
        break;
      case "post":
        post?.(action, options);
        break;
    }
  }

  return (
    <form
      id={id}
      className={cn("grid", className)}
      action={action}
      method={method}
      onSubmit={onSubmit}
      {...props}
    />
  );
}

export default FormRoot;
